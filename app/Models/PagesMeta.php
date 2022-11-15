<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagesMeta extends Model
{
    use HasFactory;

    protected $table = 'pages_meta';

    // protected $casts = [
    //     'value' => 'array'
    // ];

    protected $fillable = [
        'page_id',
        'parent_id',
        'name',
        'field_type',
        'value',
    ];

    public function page() {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }

    public function parent() {
        return $this->hasMany(PagesMeta::class, 'parent_id', 'id');
    }
}
