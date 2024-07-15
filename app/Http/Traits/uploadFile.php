<?php
namespace App\Http\Traits;

trait uploadFile {
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

    public function SaveDocument($document, $folder)
    {
        $file_extension =  $document->getClientOriginalExtension();
        $file_name = time().'.'.$file_extension;
        $path = $folder;
        $path_image = $document->move($path , $file_name);
        return $path_image;
    }
}
