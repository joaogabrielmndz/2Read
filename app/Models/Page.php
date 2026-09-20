<?php

namespace App\Models;

use App\Enums\PageScrappingStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['hash_url', 'page_url', 'title', 'content', 'scrapping_status'])]
class Page extends Model
{
    use SoftDeletes; 

    /** The attributes that should be cast. */
    protected $casts = [
        'scrapping_status' => PageScrappingStatus::class
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_page')
            ->withPivot(['custom_title', 'is_read', 'is_archived'])
            ->withTimestamps();
    }
}
