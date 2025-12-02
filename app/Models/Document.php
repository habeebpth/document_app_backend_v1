<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'date', 'category_id', 'subject', 'title',
        'description', 'content', 'file_1', 'file_2', 'status'
    ];

    // public function category()
    // {
    //     return $this->belongsTo(Category::class);
    // }


    public function category()
    {
    return $this->belongsTo(Category::class, 'category_id');
    }


    public function tags()
    {
    return $this->belongsToMany(Tag::class);
    }

}
