<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'title',
        'description',
        'location_name',
        'latitude',
        'longitude',
        'guest_name',
        'guest_email',
        'ip_address',
    ];
}
