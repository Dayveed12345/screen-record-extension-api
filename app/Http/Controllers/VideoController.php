<?php

namespace App\Http\Controllers;

use App\helpers\Helpers;
use Illuminate\Support\Facades\DB;
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
                return  $this->successJson([$timestampName, $videoSize, $videoLength, $fullVideoPath], 201);
            else :
                return $this->errorJson('Bad Request an Error Occurred', 401);
            endif;
        else :
            return $this->errorJson('An Error occurred While trying to Save file, Check Internet Connection ', 401);
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
    // public function checkingView()
    // {
    //     $getJson = file_get_contents($this->storePath('local', 'public/transcribe.json'));
    //     //    return  file_get_contents( $this->storePath('local', 'public/transcribe.json'));
    //     echo "<pre>";
    //     print_r(json_decode($getJson, JSON_PRETTY_PRINT));
    // }
    public function InsertTranscribe(int $id)
    {
        // $getID=$id;
        $get = Video::where('id', $id)->select('path')->get();

        $json = $this->transcribe($get);
        return $json;

    }
    public function truncate($table)
    {
        DB::table($table)->truncate();
        return response()->json([
            'messge'=>"Table: $table,  was deleted successfully"
        ]);
    }
};
