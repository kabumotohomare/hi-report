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

    public $fillable =[
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
        return Attribute::get(fn () => $this->category->name);
    }
    public function statusName(): Attribute
    {
        return Attribute::get(fn () => $this->latestHistory->status->name);
    }
    public function reasonName(): Attribute
    {
        return Attribute::get(fn () => $this->latestHistory->reason?->name);  // reasonはnullがあり得る
    }
    public function imagePath(): Attribute
   {
       return Attribute::get(fn () => Storage::url('images/reports/' . $this->image));
   }
    /* 
     * Scope 
     */
    public function scopeSearch(Builder $query, $params) : void
    {
        // カテゴリー検索 checkboxの値は配列なのでwhereInで検索
        if(!empty($params['category_id'])){
            $query->whereIn('category_id', $params['category_id']);
        }
    }
}
