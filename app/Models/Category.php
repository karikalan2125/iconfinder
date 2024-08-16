<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table='category';

    protected $fillable = [
        'category_id',
        'category_name',
        'title',
        'category_url_key',
        'category_search_key',
        'category_image',
        'color',
        'type',
        'meta_description',
        'is_active',
        'is_deleted'
    ];
    public function icons()
    {
        return $this->hasMany(Icon::class, 'category_id', 'category_id')
                    ->where('is_deleted', '0')
                    ->where('is_active', '0');
    }

}