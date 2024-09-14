<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportStatusHistory extends Model
{
    use HasFactory;
 
    public $fillable = [
        'report_id',
        'status_id',
        'reason_id',
        'comment',
        'start_date',
        'end_date',
        'completed_at',
    ];
}
