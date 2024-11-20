<?php

namespace App\Http\Controllers;
Use App\Models\Style;
Use App\Models\Category;
Use App\Models\License;
Use App\Models\Icon_Type;
Use App\Models\SortBy;
abstract class Controller
{
    public function __construct()
    {
        $category =Category::where('is_active', 0)->where('is_deleted',0)->take(8)->get();
        $style =Style::where('is_active', 0)->where('is_deleted',0)->take(8)->get();
        $license =License::where('is_active', 0)->where('is_deleted',0)->take(8)->get();
        $icon_type =Icon_Type::where('is_active', 0)->where('is_deleted',0)->take(8)->get();
        $sort_type =SortBy::where('is_active', 0)->where('is_deleted',0)->take(8)->get();

        view()->share(compact('category','style','license','icon_type','sort_type'));
    }
}
