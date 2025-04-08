<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description'
    ];

    public function scopeSearch($query, $value)
    {
        $query->where("name","like","%{$value}%")
                ->orWhere("description","like","%{$value}%");
    }

    /**
     * The books that belong to the category.
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }
}
