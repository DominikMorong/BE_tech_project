<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimePeriod extends Model
{
    use HasFactory;

    protected $table = "time_periods";
    protected $primaryKey = "id";

    protected $fillable = [
        'start',
        'end',
        'stage_id'
    ];

    public function talk()
    {
        return $this->belongsTo(Talk::class);
    }

    public function stage() {
        return $this->belongsTo(Stage::class);
    }
}
