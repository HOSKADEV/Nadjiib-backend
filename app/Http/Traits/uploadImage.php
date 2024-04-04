<?php
namespace App\Http\Traits;

trait uploadImage {
    public function SaveImage($image, $folder)
    {
        $file_extension =  $image->getClientOriginalExtension();
        $file_name = time().'.'.$file_extension;
        $path = $folder;
        $path_image = $image->move($path , $file_name);
        return $path_image;
    }

    public function SaveVideo($video,$folder)
    {
        $file_extension = $video->getClientOriginalExtension();
        $file_name = uniqid("video_").".".$file_extension;
        $path = $folder;
        $path_video = $video->move($path, $file_name);
        return $path_video;
    }
}