<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecyclePlant extends Model
{
    use HasFactory;

    protected $table = 'recycle_plants';

    protected $fillable = [
        'company',
        'city',
        'country',
    ];

}
