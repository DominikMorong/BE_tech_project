<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $table = "galleries";
    protected $primaryKey = "id";

    protected $fillable = [
        'imgUrl',
        'gallery_category_id'
    ];

    public function GalleryCategories() 
    {
        return $this->belongsTo(GalleryCategory::class);
    }

}
