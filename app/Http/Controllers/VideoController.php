<?php

namespace App\Http\Controllers;

use App\Http\Resources\VideoResource;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use getID3;
use Illuminate\Support\Carbon;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class VideoController extends Controller
{
    protected $video;

    public function storePath($disk, $path)
    {
        return Storage::disk($disk)->path($path);
    }
    // ...

    public function uploadVideo(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'video' => 'required|file|mimetypes:video/*|max:204800',
        ]);

        $uploadedVideo = $request->file('video');


        $timestampName ='untitled_'.time() .'.'. $uploadedVideo->getClientOriginalExtension();

        $path = $uploadedVideo->storeAs('videos',   $timestampName);
        $localPath = $uploadedVideo->storeAs('videos',   $timestampName, 'public');

        if ($path) :

            $videoInByte = $uploadedVideo->getSize() / (1024 * 1024);
            $videoSize = round($videoInByte, 2) . "mb";
            $getID3 = new getID3();
            $videoFilePath = $this->storePath('s3', $path);
            $localVideoFilePath = $this->storePath('local', 'public/' . $localPath);
            $fullVideoPath = 'https://hng-video-upload.s3.us-east-1.amazonaws.com/' . $videoFilePath;
            // $response = Http::withHeaders(['Authorization' => 'Bearer GR1EJSH7RYBZGTJLU8DL92IXTK191K1X'])
            //     ->attach('file', $fullVideoPath)
            //     ->post(
            //         'https://transcribe.whisperapi.com',
            //         [
            //             'fileType' => 'mp4',
            //             'diarization' => 'false',
            //             'task' => 'transcribe'
            //         ]
            //     );
            $fullVideoPath = 'https://hng-video-upload.s3.us-east-1.amazonaws.com/' . $videoFilePath;
            $fileInfo = $getID3->analyze($localVideoFilePath);
            $videoLength = isset($fileInfo['playtime_string']) ? $fileInfo['playtime_string'] : '00.00';
            $video = new Video;
            $video->name =   $timestampName;
            $video->size = $videoSize;
            $video->length = $videoLength;
            $video->path = $fullVideoPath;
            $video->uploaded_time = Carbon::now();
            $checking = $video->save();
            // Deleting the file from local storage
            $filePathToDelete = 'app/public/videos/' .   $timestampName;
            $fullFilePath = storage_path($filePathToDelete);
            unlink($fullFilePath);
            if ($checking) :
                return response()->json([
                    'StatusCode' => 201,
                    'message' => 'Image has been uploaded successfully',
                    'status' => 'Created',
                    'data' => [
                        'video_name' =>   $timestampName,
                        'video_size' => $videoSize,
                        'video_length' => $videoLength,
                        'video_path' => $fullVideoPath
                    ]
                    ],201);
            else :
                return response()->json([
                    'StatusCode' => 400,
                    'status' => 'error',
                    'message' => 'Bad Request an Error Occurred',

                ]);
            endif;
        else :
            return response()->json([
                'StatusCode' => 401,
                'status' => 'error',
                'message' => 'An Error occurred While trying to Save file ',

            ]);
        endif;
    }
    public function getVideo()
    {
        $video = Video::all(['id','name', 'size', 'length', 'path', 'uploaded_time']);
        if (!$video->isEmpty()) :
            return response()->json([
                'StatusCode' => 200,
                'message' => 'Image displayed Successfully',
                'status' => 'success',
                'data' => VideoResource::collection($video)
            ]);
        else :
            return response()->json([
                'StatusCode' => 404,
                'message' => 'No data found',
                'status' => 'error',
            ], 404);
        endif;
    }
};
