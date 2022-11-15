<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class Page extends Model {

    protected $fillable = [
        'name',
        'slug',
        'content',
        'parent_id',
    ];

    /**
     * Связь «один ко многим» таблицы `pages` с таблицей `pages`
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children() {
        return $this->hasMany(Page::class, 'parent_id');
    }

    /**
     * Связь «страница принадлежит» таблицы `pages` с таблицей `pages`
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent() {
        return $this->belongsTo(Page::class);
    }

    public function custom_field($name, $type = null) {
        if ( $type == 'products' ) {
            $items = $this->belongsTo(PagesMeta::class, 'id', 'page_id')->where('name', $name)->first()['value'] ?? '';
            $items = explode(',', $items);
            return Product::whereIn('id', $items)->get() ?? '';
        } else {
            return $this->belongsTo(PagesMeta::class, 'id', 'page_id')->where('name', $name)->first()['value'] ?? '';
        }
    }
}
