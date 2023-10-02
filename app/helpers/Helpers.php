<?php

namespace App\helpers;

use App\Models\Video;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
trait Helpers
{
    public function storePath($disk, $path)
    {
        return Storage::disk($disk)->path($path);
    }
    public function transcribe($fullVideoPath)
    {
        $url = fopen($fullVideoPath, 'r');
        $response = Http::withHeaders(['Authorization' => 'Bearer GR1EJSH7RYBZGTJLU8DL92IXTK191K1X'])
            ->attach('file', $url)
            ->post(
                'https://transcribe.whisperapi.com',
                [
                    'fileType' => 'mp4',
                    'diarization' => 'false',
                    'task' => 'transcribe'
                ]
            );
        dd($response->json());
    }
    public function successJson( $array=[], int $statusCode){
        return response()->json([
            'StatusCode' => 201,
            'message' => 'Image has been uploaded successfully',
            'status' => 'Created',
            'data' => [
                'video_name' =>   $array[0],
                'video_size' => $array[1],
                'video_length' => $array[2],
                'video_path' => $array[3]
            ]
            ],$statusCode);
    }
    public function errorJson($message,$statusCode){
        return response()->json([
            'StatusCode' => $statusCode,
            'status' => 'error',
            'message' => $message,
        ]);
    }
    public function fetchOrFailData($statusCode,$status,$video=[]){
        return response()->json([
            'StatusCode' => $statusCode,
            'status' => $status,
            'data' =>$video
        ],$statusCode);
    }
    public function saveVideo($array=[]){
        $video = new Video;
        $video->name =   $array[0];
        $video->size = $array[1];
        $video->length = $array[2];
        $video->path = $array[3];
        $video->uploaded_time = $array[4];
        $checking = $video->save();
       if(!$checking):
        return false;
       else:
        return true;
       endif;
    }
}
