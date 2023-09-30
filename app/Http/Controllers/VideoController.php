<?php

namespace App\Http\Controllers;

use App\Http\Resources\VideoResource;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use getID3;
use Illuminate\Support\Carbon;

class VideoController extends Controller
{


    // ...

    public function uploadVideo(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'video' => 'required|file|mimetypes:video/*|max:204800',
        ]);

        // Store the video file on the "videos" disk
        $uploadedVideo = $request->file('video');
        // Get the name of the uploaded video file
        $videoName = $uploadedVideo->getClientOriginalName();
        $path = $uploadedVideo->storeAs('public',$videoName);
        // dd($path);
        if($path):
        // Get the size of the uploaded video file in bytes
        $videoInByte = $uploadedVideo->getSize() /(1024 * 1024);
        //Converting to KiloByte;
        $videoSize=round($videoInByte,2)."mb";

        // Get the video length using getID3
        $getID3 = new getID3();
        $videoFilePath = Storage::disk('public')->path($videoName);
      // Get the full path to the video file
        $fileInfo = $getID3->analyze($videoFilePath);
        // Checking if the User
        $videoLength = isset( $fileInfo['playtime_string']) ?$fileInfo['playtime_string']: null;
        // Store The video and other credentials to the database
        $video = new Video;
        $video->name = $videoName;
        $video->size = $videoSize;
        $video->length = $videoLength;
        $video->path = $videoFilePath;
        $video->uploaded_time=Carbon::now();
        $checking = $video->save();
        if ($checking) :
            return response()->json([
                'StatusCode' => 201,
                'message' => 'Image has been uploaded successfully',
                'status' => 'success',
                'data' => [
                    'video_name' => $videoName,
                    'video_size' => $videoSize,
                    'video_length' => $videoLength,
                    'video_path' => $videoFilePath
                ]
            ]);
        else :
            return response()->json([
                'StatusCode' => 400,
                'message' => 'Bad Request an Error Occurred',
                'status' => 'error',
            ]);
        endif;
    else:
        return response()->json([
            'StatusCode' => 401,
            'message' => 'An Error occurred While trying to Save file ',
            'status' => 'error',
        ]);
    endif;
    }
    public function getVideo(){
        $video=Video::all(['name','size','length','path','uploaded_time']);
        if ($video) :
            return response()->json([
                'StatusCode' => 200,
                'message' => 'Image displayed Successfully',
                'status' => 'success',
                'data' => VideoResource::collection($video)
            ]);
        else :
            return response()->json([
                'StatusCode' => 400,
                'message' => 'An Error Occurred',
                'status' => 'error',
            ]);
        endif;

    }
}
