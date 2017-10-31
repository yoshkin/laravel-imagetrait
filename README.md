# Laravel ImageTrait
> for Hacktoberfest 2017

ImageTrait for Laravel 5.4

## Requirements
* laravel 5.4^
(Because trait uses Storage and Image class of laravel package)

## Features
Handle image file upload and DB storage for a image file:
- on CREATE:
* stores the image file at the destination path
* generates a name
* stores the path in the DB;

- on UPDATE:
* if the value is null, deletes the image file and sets null in the DB
* if the value is different, stores the different image file and updates DB value.

## Installing #1
```
composer require yashenkov/laravel-imagetrait
```
## Installing #2
```
Download ImageTrait.php, than place it in app/Traits. 
Replace namespase "Yashenkov\ImageTrait\Traits" by "App\Traits"
```

#### Using:
In your model, that have image attribute you need to 
add in Model use ImageTrait, for example:
```php
<?php
namespace App\Models;

use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use ImageTrait;
    ...
}
```

Then you can use method of the trait in Model class as mutator of image attribute:
```php
<?php
namespace App\Models;

use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use ImageTrait;
    
    public $disk = "uploads";
    public $destination_path = "products";
    public $imageWidth = 270;
    public $imageHeight = 270;
        
    /**
    * Mutators
    */
    
    public function setImageAttribute($value, $attribute_name = 'image')
    {
        $this->uploadImageToDisk($value, $attribute_name, $this->disk, $this->destination_path, $this->imageWidth, $this->imageHeight);
    }
}
```

##Licence
MIT



