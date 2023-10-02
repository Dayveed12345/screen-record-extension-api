<?php

namespace App\Http\Controllers;

use App\helpers\Helpers;
use App\Http\Resources\VideoResource;
use App\Models\segment;
use App\Models\transcript;
use App\Models\Video;
use App\Models\word;
use Illuminate\Http\Request;

use getID3;
use Illuminate\Support\Carbon;
use Illuminate\Http\Client\PendingRequest;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class VideoController extends Controller
{
    use Helpers;
    protected $video;
    public function uploadVideo(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'video' => 'required|file|mimetypes:video/*|max:204800',
        ]);

        $uploadedVideo = $request->file('video');

        $timestampName = 'untitled_' . time() . '.' . $uploadedVideo->getClientOriginalExtension();

        $path = $uploadedVideo->storeAs('videos',   $timestampName);
        $localPath = $uploadedVideo->storeAs('videos',   $timestampName, 'public');

        if ($path) :

            $videoInByte = $uploadedVideo->getSize() / (1024 * 1024);
            $videoSize = round($videoInByte, 2) . "mb";
            $getID3 = new getID3();
            $videoFilePath = $this->storePath('s3', $path);
            $localVideoFilePath = $this->storePath('local', 'public/' . $localPath);
            $fullVideoPath = 'https://hng-video-upload.s3.us-east-1.amazonaws.com/' . $videoFilePath;
            $fileInfo = $getID3->analyze($localVideoFilePath);
            $videoLength = isset($fileInfo['playtime_string']) ? $fileInfo['playtime_string'] : '00.00';
            // $this->transcribe($fullVideoPath);
            $save = $this->saveVideo([
                $timestampName,
                $videoSize,
                $videoLength,
                $fullVideoPath,
                Carbon::now()
            ]);
            // Deleting the file from local storage
            $filePathToDelete = 'app/public/videos/' .   $timestampName;
            $fullFilePath = storage_path($filePathToDelete);
            unlink($fullFilePath);
            if ($save) :
                $videoId = Video::where('name', $timestampName)->select(['id'])->get();
                $this->InsertTranscribe($videoId, $fullVideoPath);
                return  $this->successJson([$timestampName, $videoSize, $videoLength, $fullVideoPath], 201);
            else :
                return $this->errorJson('Bad Request an Error Occurred', 401);
            endif;
        else :
            return $this->errorJson('An Error occurred While trying to Save file ', 401);
        endif;
    }
    public function getVideo()
    {
        $video = Video::all(['id', 'name', 'size', 'length', 'path', 'uploaded_time']);
        if (!$video->isEmpty()) :
            return $this->fetchOrFailData(200, 'success', VideoResource::collection($video));
        else :
            return $this->fetchOrFailData(404, 'error', 'no data found');
        endif;
    }
    public function checkingView()
    {
        $getJson = file_get_contents($this->storePath('local', 'public/transcribe.json'));
        //    return  file_get_contents( $this->storePath('local', 'public/transcribe.json'));
        echo "<pre>";
        print_r(json_decode($getJson, JSON_PRETTY_PRINT));
    }
    public function InsertTranscribe(int $id, $fullVideoPath)
    {
        $getID = $id;
        // Instantiating all models and tables for transcription
        $seg = new segment;
        $trans = new transcript;
        $word = new word;
        // $Json = file_get_contents($this->storePath('local', 'public/transcribe.json'));
        $json = $this->transcribe($fullVideoPath);
        $getJson = json_decode($json, JSON_PRETTY_PRINT);

        foreach ($getJson as $get) {
            $trans->videos_id = $getID;
            $trans->text = $get['text'];
            $trans->language = $get['language'];
            $trans->save();
            foreach ($get['segments'] as $segment) {
                $seg->transcripts_id = $getID;
                $seg->start = $segment['start'];
                $seg->end =  $segment['end'];
                $seg->text = $segment['text'];
                $seg->save();
                foreach ($segment['whole_word_timestamps'] as $whole_word_timestamps) {
                    $word->segments_id = $getID;
                    $word->word = $whole_word_timestamps['word'];
                    $word->start = $whole_word_timestamps['start'];
                    $word->end = $whole_word_timestamps['end'];
                    $word->probability = $whole_word_timestamps['probability'];
                    $word->timestamp = $whole_word_timestamps['timestamp'];
                    $word->save();
                }
            }
        }
    }
};
