<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /* 
    * Relation
    */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
    public function reason(): BelongsTo
    {
        return $this->belongsTo(Reason::class);
    }
}
