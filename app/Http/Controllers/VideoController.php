<?php

namespace App\Http\Controllers;

use App\helpers\Helpers;
use App\Http\Resources\VideoResource;
use App\Models\Video;
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
           $save= $this->saveVideo([
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
};
