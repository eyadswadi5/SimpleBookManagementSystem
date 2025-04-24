<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Book extends Model
{
    protected $fillable = [
        "name", "author", "quantity", "date_of_product", "description", "number_of_pages"
    ];
    
    public function cover(): HasOne {
        return $this->hasOne(Image::class);
    }
}
