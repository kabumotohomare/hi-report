<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Report extends Model
{
    use HasFactory;
    use HasUuids;

    public $fillable = [
        'category_id',
        'latitude',
        'longitude',
        'detail',
        'email',
        'contact',
        'reported_at',
    ];
    protected $casts = [
        'reported_at' => 'datetime'
    ];
    /* 
     * Relation
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function latestHistory()
    {
        return $this->hasOne(ReportStatusHistory::class)->ofMany('updated_at', 'max');
    }
    /*
     * Accessor
     */
    public function categoryName(): Attribute
    {
        return Attribute::get(fn() => $this->category->name);
    }
    public function statusName(): Attribute
    {
        return Attribute::get(fn() => $this->latestHistory->status->name);
    }
    public function reasonName(): Attribute
    {
        return Attribute::get(fn() => $this->latestHistory->reason?->name);  // reasonはnullがあり得る
    }
    public function imagePath(): Attribute
    {
        return Attribute::get(fn() => Storage::url('images/reports/' . $this->image));
    }
    /* 
     * Scope 
     */
    public function scopeSearch(Builder $query, $params): void
    {
        // カテゴリー検索 checkboxの値は配列なのでwhereInで検索
        if (!empty($params['category_id'])) {
            $query->whereIn('category_id', $params['category_id']);
        }
        // 対応状況検索 リレーション先のカラムで検索するのでwhereHasを使う
        if (!empty($params['status_id'])) {
            $query->whereHas('latestHistory', function ($q) use ($params) {
                // checkboxの値は配列なのでwhereInで検索
                $q->whereIn('status_id', $params['status_id']);
            });
        }
       // 報告日検索 範囲検索
       if (!empty($params['reported_start_date'])) {
           $query->where('reported_at', '>=', $params['reported_start_date']);
       }
       if (!empty($params['reported_end_date'])) {
           $query->where('reported_at', '<=', $params['reported_end_date'] . " 23:59:59");
       }
       // 対応予定検索 重複範囲検索
       if (!empty($params['start_date'])) {
           $query->whereRelation('latestHistory', 'end_date', '>=', $params['start_date']);
       }
       if (!empty($params['end_date'])) {
           $query->whereRelation('latestHistory', 'start_date', '<=', $params['end_date'] . " 23:59:59");
       }
       // 完了検索 範囲検索
       if (!empty($params['completed_start_date'])) {
           $query->whereRelation('latestHistory', 'completed_at', '>=', $params['completed_start_date'] . " 00:00:00");
       }
       if (!empty($params['completed_end_date'])) {
           $query->whereRelation('latestHistory', 'completed_at', '<=', $params['completed_end_date'] . " 23:59:59");
       }
    }
}
