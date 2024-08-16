<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Category;
Use App\Models\Style;
Use App\Models\Icon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;

class IconFinderController extends Controller
{
    public function home ()
    {
        $hme_category=Style::where('is_active','0')->where('is_deleted','0')->take(3)->get();
        return view('iconfinder/home',compact('hme_category'));
    }

    public function category(Request $request)
    {
        if($request->ajax()){
            $all_icons = Icon::where('is_active', '0')
            ->where('is_deleted', '0')
            ->with(['style' => function ($query) {
                $query->select('style_id', 'style_name', 'style_url_key');
            }])
            ->paginate(24)->map(function ($icon) {
                $icon->random_icons = Icon::where('is_active', '0')
                                         ->where('is_deleted', '0')
                                         ->inRandomOrder()
                                         ->take(4)
                                         ->get();
                return $icon;
            });
            // dd($all_icons);
            $html = view('render/category', compact('all_icons'))->render();
            return response()->json($html);
        }
            $all_icons = Icon::where('is_active', '0')
                    ->where('is_deleted', '0')
                    ->with(['style' => function ($query) {
                        $query->select('style_id', 'style_name', 'style_url_key');
                    }])
                    ->paginate(24);
            $all_icons->getCollection()->transform(function ($icon) {
                $icon->random_icons = Icon::where('is_active', '0')
                                        ->where('is_deleted', '0')
                                        ->inRandomOrder()
                                        ->take(4)
                                        ->get();
                return $icon;
            });
            $totalRecords = $all_icons->lastPage();
        return view('iconfinder/category', compact('all_icons','totalRecords'));
    }
    
    public function cat_subcategory (Request $request)
    {
       $cat_slug= $request->slug;
       $sub_category=Category::where('category_url_key',$cat_slug)->where('is_active','0')->where('is_deleted','0')->first();
       $Icon=Icon::where('category_id',$sub_category->category_id)->where('is_active','0')->where('is_deleted','0')->take(6)->get();
       $Icon_count=Icon::where('category_id',$sub_category->category_id)->where('is_active','0')->where('is_deleted','0')->count();

        return view('iconfinder/subcategory',compact('sub_category','Icon','Icon_count'));
    }

    public function style_subcategory (Request $request)
    {
        $cat_slug= $request->slug;
        $style_id=Style::select('style_id')->where('style_url_key',$cat_slug)->where('is_active','0')->where('is_deleted','0')->first();
        // dd($style_id);
        $iconsGroupedByCategory = Icon::where('style_id', $style_id ->style_id)
                                ->where('is_active', '0')
                                ->where('is_deleted', '0')
                                ->get()
                                ->groupBy('category_id')
                                ->map(function ($icons) {
                                    return [
                                        'category' => $icons->first()->sub_category,
                                        'icons' => $icons->take(6),
                                        'count' => $icons->count(),
                                    ];
                                });
        // dd($iconsGroupedByCategory);
        return view('iconfinder/subcategory1',compact('iconsGroupedByCategory','cat_slug'));
    }

    public function detail(Request $request)
    {
        if($request->ajax()){

            $selected_license_val = $request->input('selected_license_val');
            $selected_style_val = $request->input('selected_style_val');
            $selected_icon_val = $request->input('selected_icon_val');
            $selected_sortby_val = $request->input('selected_sortby_val');
            $cat_slug = $request->input('cat_slug');
            $sub_category=Category::where('category_url_key',$cat_slug)->where('is_active','0')->where('is_deleted','0')->first();

            $Icon_dtl=Icon::where('category_id',$sub_category->category_id)->where('is_active','0')->where('is_deleted','0');

            if($selected_license_val){
                if($selected_license_val != "all"){
                    $Icon_dtl->where('license_id',$selected_license_val);
                }
            }   
            if($selected_style_val){
                if($selected_style_val != "all"){
                    $Icon_dtl->where('style_id',$selected_style_val);
                }
            }   
            if($selected_icon_val){
                if($selected_icon_val != "all"){
                    $Icon_dtl->where('icon_type_id',$selected_icon_val);
                }
            }   
            if($selected_sortby_val){
                if($selected_sortby_val != "all"){
                    $Icon_dtl->where('sort_by_id',$selected_sortby_val);
                }
            }   

            $list =  $Icon_dtl->get();
            $relatedIcons = Icon::where('category_id', $sub_category->category_id)
                            ->where('is_active', '0')
                            ->where('is_deleted', '0')
                            ->inRandomOrder()
                            ->take(20)
                            ->get();
            // dd($list);
            $html = view('render/filter', compact('list','relatedIcons'))->render();
            return response()->json($html);
        }
        $cat_slug= $request->cat_slug;
        // dd($cat_slug);
        $cat_id=Category::where('category_url_key',$cat_slug)->where('is_active','0')->where('is_deleted','0')->first();
        $Icon_dtl=Icon::where('category_id',$cat_id->category_id)->where('is_active','0')->where('is_deleted','0')->first();
        $relatedIcons = Icon::where('category_id', $cat_id->category_id)
                            ->where('is_active', '0')
                            ->where('is_deleted', '0')
                            ->inRandomOrder()
                            ->take(20)
                            ->get();
        return view('iconfinder/detail',compact('Icon_dtl','relatedIcons','cat_slug','cat_id'));
    }

    public function search(Request $request)
    {
        if($request->ajax()){
            $selected_license_val = $request->input('selected_license_val');
            $selected_style_val = $request->input('selected_style_val');
            $selected_icon_val = $request->input('selected_icon_val');
            $selected_sortby_val = $request->input('selected_sortby_val');
            $query = $request->input('result');
            // dd($query);

            $Icon_dtl = Icon::where(function($q) use ($query) {
                    $q->where('icon_search_key', 'LIKE', '%' . $query . '%')
                    ->orWhereHas('sub_category', function($q2) use ($query) {
                        $q2->where('category_name', 'LIKE', '%' . $query . '%');
                    });
                    })
                    ->where('is_active', '0')
                    ->where('is_deleted', '0')
                    ->with(['sub_category' => function($query) {
                        $query->select('category_id', 'category_name');
                    }]);
                
            if($selected_license_val){
                if($selected_license_val != "all"){
                    $Icon_dtl->where('license_id',$selected_license_val);
                }
            }   
            if($selected_style_val){
                if($selected_style_val != "all"){
                    $Icon_dtl->where('style_id',$selected_style_val);
                }
            }   
            if($selected_icon_val){
                if($selected_icon_val != "all"){
                    $Icon_dtl->where('icon_type_id',$selected_icon_val);
                }
            }   
            if($selected_sortby_val){
                if($selected_sortby_val != "all"){
                    $Icon_dtl->where('sort_by_id',$selected_sortby_val);
                }
            }   

            $list =  $Icon_dtl->get();

            // dd($list);
            $html = view('render/srch_filter', compact('list'))->render();
            // dd($html);
            return response()->json($html);
        }

        $query = $request->input('search');
    
        $result = Icon::where(function($q) use ($query) {
            $q->where('icon_search_key', 'LIKE', '%' . $query . '%')
              ->orWhereHas('sub_category', function($q2) use ($query) {
                  $q2->where('category_name', 'LIKE', '%' . $query . '%');
              });
            })
            ->where('is_active', '0')
            ->where('is_deleted', '0')
            ->with(['sub_category' => function($query) {
                $query->select('category_id', 'category_name');
            }])
            ->get();

        $relatedIcons = Icon::where('is_active', '0')
            ->where('is_deleted', '0')
            ->inRandomOrder()
            ->take(20)
            ->get();
    
        return view('iconfinder.search', compact('result', 'query', 'relatedIcons'));
    }

    public function download(Request $request)
    {
        $url = $request->imgUrl;
        // dd($url);
        $active_txt = $request->active_txt;

        if ($url == null) {
            return back()->with('error', 'Image URL is required');
        }

        // Validate URL
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return back()->with('error', 'Invalid Image URL');
        }

        // Extract file name and extension
        $urlParts = parse_url($url);
        if (!$urlParts || !isset($urlParts['path'])) {
            return back()->with('error', 'Invalid URL format');
        }
        $path = $urlParts['path'];
        $filename = basename($path);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        // Define save path
        $savePath = public_path('Image_category/');

        // Determine filename and full path based on whether size is selected or not
        if ($active_txt != null) {
            // Selected size case
            $localFilename = time() . '_' . str_replace(' ', '', $active_txt) . '.' . $extension;
        } else {
            // Default image case
            $localFilename = time() . '_default.' . $extension;
        }

        $fullPath = $savePath . $localFilename;

        // Allowed extensions
        $allowedExtensions = ['jpg', 'png', 'jpeg', 'svg'];

        // Validate extension
        if (!in_array(strtolower($extension), $allowedExtensions)) {
            return back()->with('error', 'Unsupported file type');
        }

        // Ensure the directory exists
        if (!File::isDirectory($savePath)) {
            File::makeDirectory($savePath, 0755, true);
        }

        try {
            // Fetch the file
            $response = Http::get($url);
            if ($response->successful()) {
                // Save the file
                File::put($fullPath, $response->body());
            } else {
                return back()->with('error', 'Failed to download the image');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to download the image: ' . $e->getMessage());
        }

        // Provide the file for download
        if (File::exists($fullPath)) {
            Log::info('File saved successfully: ' . $fullPath);

            // Return the file as a download response
            return response()->download($fullPath, $filename)->deleteFileAfterSend(true);
        } else {
            return back()->with('error', 'Failed to save the image file');
        }
    }


}
