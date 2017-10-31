<?php
/**
 * Created by PhpStorm.
 * User: yashenkov
 * Date: 20.10.17
 * Time: 8:53
 */
namespace App\Traits;

trait ImageTrait
{
    public function uploadImageToDisk($value, $attribute_name, $disk, $destination_path, $width = 270, $height = 270)
    {
        // if a new image file is uploaded, delete the file from the disk
        if (starts_with($value, 'data:image') &&
            $this->{$attribute_name} &&
            $this->{$attribute_name} != null) {
            \Storage::disk($disk)->delete($destination_path.'/'.$this->{$attribute_name}, $destination_path.'-thumbs/'.$this->{$attribute_name});
            $this->attributes[$attribute_name] = null;
        }
        // if the file input is empty, delete the file from the disk
        if (is_null($value) && $this->{$attribute_name} != null) {
            \Storage::disk($disk)->delete($destination_path.'/'.$this->{$attribute_name}, $destination_path.'-thumbs/'.$this->{$attribute_name});
            $this->attributes[$attribute_name] = null;
        }
        // if a new file is uploaded, store it on disk and its filename in the database
        if (starts_with($value, 'data:image')) {
            // 1. Make the main image
            $image = \Image::make($value)->resize($width, $height);
            // 2. Make thumb
            $thumb = \Image::make($value)->resize($width/3.375, $height/3.375);
            // 3. Generate a filename.
            $filename = md5($value.time()).'.jpg';
            // 4. Store the image on disk.
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
            \Storage::disk($disk)->put($destination_path.'-thumbs/'.$filename, $thumb->stream());
            // 5. Save the path to the database
            $this->attributes[$attribute_name] = $filename;
        }
    }
}