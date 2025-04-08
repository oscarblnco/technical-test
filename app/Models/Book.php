<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'author',
        'editorial',
        'year_publication',
        'read'
    ];

    public function scopeSearch($query, $value)
    {
        $query->where('title',"like","%{$value}%")
                ->orWhere('author',"like","%{$value}%")
                ->orWhere('editorial',"like","%{$value}%")
                ->orWhere('year_publication',"like","%{$value}%");
    }

    /**
     * The books that belong to the category.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(category::class);
    }
}
