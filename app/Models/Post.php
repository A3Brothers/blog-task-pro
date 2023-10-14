<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mews\Purifier\Casts\CleanHtml;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content'
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'user:id,name'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $cast = [
        'content' => CleanHtml::class
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->slug = Str::slug($model->title);
            $model->published_at = now();
        });

        self::updating(function ($model) {
            $model->slug = Str::slug($model->title);
        });
    }

    protected function title(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucwords($value)
        );
    }

    protected function publishedAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
