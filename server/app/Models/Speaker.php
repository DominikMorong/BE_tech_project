<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    use HasFactory;

    protected $table = 'speakers';
    protected $primaryKey = 'id';

    protected $fillable = ['firstName', 'lastName', 'imgUrl', 'description', 'descriptionShort', 'xFormerlyKnownAsTwitterProfile', 'facebookProfile', 'personalPage'];
}