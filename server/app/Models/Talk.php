<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talk extends Model
{
    use HasFactory;

    protected $table = "talks";
    protected $primaryKey = "id";

    protected $fillable = [
        'description',
        'descriptionShort',
        'speaker_id',
    ];

    public function speaker()
    {
        return $this->belongsTo(Speaker::class);
    }

    public function timePeriod() 
    {
        return $this->hasOne(TimePeriod::class);
    }
}
