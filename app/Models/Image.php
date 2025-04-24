<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        "book_id", "file_name", "path", "url", "size"
    ];
}
