<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    use HasFactory;
    protected $table='icon';
    protected $primaryKey='icon_id';

    protected $fillable = [
        'icon_id',
        'icon_name',
        'title',
        'icon_url',
        'single_or_multiple_upload',
        'iconImageUploadType',
        'sub_category_id',
        'category_id',
        'style_id',
        'color',
        'icon_type_id',
        'license_id',
        'sort_by_id',
        'color_id',
        'pricing',
        'icon_format',
        'icon_views',
        'icon_url_key',
        'icon_search_key',
        'source_format_type',
        'icon_size',
        'meta_description'
    ];

    public function style()
    {
        return $this->belongsTo(Style::class, 'style_id', 'style_id')
                    ->where('is_deleted', '0')
                    ->where('is_active', '0');
    }
    public function sub_category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id')
                    ->where('is_deleted', '0')
                    ->where('is_active', '0');
    }

}

