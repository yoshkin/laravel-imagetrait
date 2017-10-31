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
        if (starts_with($value, 'data:image') &&
            $this->{$attribute_name} &&
            $this->{$attribute_name} != null) {
            \Storage::disk($disk)->delete($destination_path.'/'.$this->{$attribute_name}, $destination_path.'-thumbs/'.$this->{$attribute_name});
            $this->attributes[$attribute_name] = null;
        }
        if (is_null($value) && $this->{$attribute_name} != null) {
            \Storage::disk($disk)->delete($destination_path.'/'.$this->{$attribute_name}, $destination_path.'-thumbs/'.$this->{$attribute_name});
            $this->attributes[$attribute_name] = null;
        }
        if (starts_with($value, 'data:image')) {
            $image = \Image::make($value)->resize($width, $height);
            $thumb = \Image::make($value)->resize($width/3.375, $height/3.375);
            $filename = md5($value.time()).'.jpg';
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
            \Storage::disk($disk)->put($destination_path.'-thumbs/'.$filename, $thumb->stream());
            $this->attributes[$attribute_name] = $filename;
        }
    }
}