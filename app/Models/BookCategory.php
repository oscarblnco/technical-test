<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookCategory extends Model
{
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'book_category';

    protected $fillable = [
        'book_id',
        'category_id'
    ];

    
}
