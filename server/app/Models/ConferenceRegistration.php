<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConferenceRegistration extends Model
{
    use HasFactory;

    protected $table = 'conference_registrations';
    protected $primaryKey = 'id';

    protected $fillable = ['email', 'cancelationToken'];
}
