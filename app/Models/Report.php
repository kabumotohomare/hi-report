<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    use HasUuids;

    public $fillable =[
        'category_id',
        'latitude',
        'longitude',
        'detail',
        'email',
        'contact',
        'reported_at',
    ];
}
