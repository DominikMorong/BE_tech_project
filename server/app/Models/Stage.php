<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stage extends Model
{
    use HasFactory;

    protected $table = "stages";
    protected $primaryKey = "id";

    protected $fillable = [
        'name',
        'date',
    ];

    public function timePeriods(): HasMany
    {
        return $this->hasMany(TimePeriod::class);
    }

}
