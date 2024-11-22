<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Category;
Use App\Models\Style;
Use App\Models\Icon;
use App\Models\UserSession;
use DOMDocument;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Imagick;
use ImagickPixel;

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
            ->where('license_id', '!=', 2)
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
            $html = view('render/category', compact('all_icons'))->render();
            return response()->json($html);
        }
            $all_icons = Icon::where('is_active', '0')
                    ->where('is_deleted', '0')
                    ->where('license_id', '!=', 2)
                    ->with(['style' => function ($query) {
                        $query->select('style_id', 'style_name', 'style_url_key');
                    }])
                    ->paginate(24);
            $all_icons->getCollection()->transform(function ($icon) {
                $icon->random_icons = Icon::where('is_active', '0')
                                        ->where('is_deleted', '0')
                                        ->where('license_id', '!=', 2)
                                        ->inRandomOrder()
                                        ->take(4)
                                        ->get();
                return $icon;
            });
            $totalRecords = $all_icons->lastPage();
            // dd($all_icons);
        return view('iconfinder/category', compact('all_icons','totalRecords'));
    }

    public function cat_subcategory (Request $request)
    {
       $cat_slug= $request->slug;
       $sub_category=Category::where('category_url_key',$cat_slug)->where('is_active','0')->where('is_deleted','0')->first();
       $Icon=Icon::where('category_id',$sub_category->category_id)->where('is_active','0')->where('license_id', '!=', 2)->where('is_deleted','0')->take(6)->get();
       $Icon_count=Icon::where('category_id',$sub_category->category_id)->where('license_id', '!=', 2)->where('is_active','0')->where('is_deleted','0')->count();

        return view('iconfinder/subcategory',compact('sub_category','Icon','Icon_count'));
    }

    public function style_subcategory (Request $request)
    {
        $cat_slug= $request->slug;
        // dd($cat_slug);
        $style_id=Style::select('style_id')->where('style_url_key',$cat_slug)->where('is_active','0')->where('is_deleted','0')->first();
        // dd($style_id);
        $iconsGroupedByCategory = Icon::where('style_id', $style_id ->style_id)
                                ->where('is_active', '0')
                                ->where('is_deleted', '0')
                                ->where('license_id', '!=', 2)
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

            $Icon_dtl=Icon::where('category_id',$sub_category->category_id)->where('license_id', '!=', 2)->where('is_active','0')->where('is_deleted','0');

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
                            ->where('license_id', '!=', 2)
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
        $Icon_dtl=Icon::where('category_id',$cat_id->category_id)->where('license_id', '!=', 2)->where('is_active','0')->where('is_deleted','0')->first();
        $relatedIcons = Icon::where('is_active', '0')
        ->where('is_deleted', '0')
        ->where('license_id', '!=', 2)
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
                    ->where('license_id', '!=', 2)
                    ->where('is_active', '0')
                    ->where('is_deleted', '0')
                    ->with(['sub_category' => function($query) {
                        $query->select('category_id', 'category_name');
                    }]);
                    // dd($Icon_dtl);
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

        $request->validate([
            'search'=>'required|string'
        ],
        [
            'search.required' => 'The search field is required.',

        ]);

        $query = $request->input('search');

        $Icon_dtl = Icon::where(function($q) use ($query) {
            $q->where('icon_search_key', 'LIKE', '%' . $query . '%')
              ->orWhereHas('sub_category', function($q2) use ($query) {
                  $q2->where('category_name', 'LIKE', '%' . $query . '%');
              });
            })
            ->where('license_id', '!=', 2)
            ->where('is_active', '0')
            ->where('is_deleted', '0')
            ->with(['sub_category' => function($query) {
                $query->select('category_id', 'category_name');
            }])
            ->get();
            // dd($Icon_dtl->icon_url);
        $relatedIcons = Icon::where('is_active', '0')
            ->where('is_deleted', '0')
            ->where('license_id', '!=', 2)
            ->inRandomOrder()
            ->take(20)
            ->get();

        return view('iconfinder.search', compact('Icon_dtl', 'query', 'relatedIcons'));
    }

    public function download(Request $request)
    {
        $url = $request->imgUrl;
        // dd($url);
        $active_txt = (int) $request->active_txt;
        $format=$request->format;
        $color=$request->color;
        // dd($format);

        switch ($format){
            case 'png':
                if ($url == null) {
                    return back()->with('error', 'Image URL is required');
                }

                if (!filter_var($url, FILTER_VALIDATE_URL)) {
                    return back()->with('error', 'Invalid Image URL');
                }

                try {
                    $contents = @file_get_contents($url);
                    if ($contents === false) {
                        return back()->with('error', 'Failed to retrieve image from URL');
                    }
                    if ($color && strpos($contents, '<svg') !== false) {
                        // Parse the SVG content and replace colors
                        $dom = new DOMDocument();
                        libxml_use_internal_errors(true); // Suppress parsing errors for invalid SVG
                        $dom->loadXML($contents);
                        libxml_clear_errors();

                        // Change the `fill` or `stroke` attributes to the desired color
                        $svgElements = $dom->getElementsByTagName('svg');
                        if ($svgElements->length > 0) {
                            $svgElement = $svgElements->item(0);
                            $svgElement->setAttribute('fill', $color); // Replace the color
                        }

                        $pathElements = $dom->getElementsByTagName('path');
                        foreach ($pathElements as $path) {
                            $path->setAttribute('fill', $color); // Replace `fill` color
                            $path->setAttribute('stroke', $color); // Replace `stroke` color if needed
                        }

                        $contents = $dom->saveXML();
                    }
                    $name = basename(parse_url($url, PHP_URL_PATH));
                    $actualname = pathinfo($name, PATHINFO_FILENAME);

                    //Convert into PNG
                    $image = new Imagick();
                    $image->setBackgroundColor(new ImagickPixel('transparent'));
                    $image->readImageBlob($contents);
                    $image->setResolution(300, 300);
                    $image->setImageFormat('png');
                    //Convert into Selected Size
                    $resizedImage = clone $image;
                    $resizedImage->resizeImage($active_txt, $active_txt, Imagick::FILTER_LANCZOS, 1);


                    $directoryPath = Storage::path('/Image_category');
                    if (!file_exists($directoryPath)) {
                        mkdir($directoryPath, 0755, true);
                    }

                    $outputPath =  $directoryPath . '/' . $actualname . '.png';
                    // dd($outputPath);
                    $resizedImage->writeImage($outputPath);

                    // Clean up memory
                    $image->destroy();
                    $resizedImage->destroy();

                    // Generate a unique filename for download
                    $newname = $actualname . '_' . time() . '.png';
                    $headers = ['Content-Type: image/png',
                    'Content-Disposition' => 'attachment; filename="' . $actualname . '.png"'  // Force download with the actual name
                    ];

                    return response()->download($outputPath,$newname,$headers);
                } catch (Exception $e) {
                    return back()->with('error', 'An error occurred while processing the image: ' . $e->getMessage());
                }
            case 'jpeg':
                if ($url == null) {
                    return back()->with('error', 'Image URL is required');
                }

                if (!filter_var($url, FILTER_VALIDATE_URL)) {
                    return back()->with('error', 'Invalid Image URL');
                }

                try {
                    $contents = @file_get_contents($url);
                    if ($contents === false) {
                        return back()->with('error', 'Failed to retrieve image from URL');
                    }
                    if ($color && strpos($contents, '<svg') !== false) {
                        // Parse the SVG content and replace colors
                        $dom = new DOMDocument();
                        libxml_use_internal_errors(true); // Suppress parsing errors for invalid SVG
                        $dom->loadXML($contents);
                        libxml_clear_errors();

                        // Change the `fill` or `stroke` attributes to the desired color
                        $svgElements = $dom->getElementsByTagName('svg');
                        if ($svgElements->length > 0) {
                            $svgElement = $svgElements->item(0);
                            $svgElement->setAttribute('fill', $color); // Replace the color
                        }

                        $pathElements = $dom->getElementsByTagName('path');
                        foreach ($pathElements as $path) {
                            $path->setAttribute('fill', $color); // Replace `fill` color
                            $path->setAttribute('stroke', $color); // Replace `stroke` color if needed
                        }

                        $contents = $dom->saveXML();
                    }

                    $name = basename(parse_url($url, PHP_URL_PATH));
                    $actualname = pathinfo($name, PATHINFO_FILENAME);

                    //Convert into PNG
                    $image = new Imagick();
                    $image->setBackgroundColor(new ImagickPixel('white'));
                    $image->readImageBlob($contents);
                    $image->setResolution(1024, 1024);
                    $image->setImageFormat('jpeg');

                    //Convert into Selected Size
                    $resizedImage = clone $image;
                    $resizedImage->resizeImage($active_txt, $active_txt, Imagick::FILTER_LANCZOS, 1);

                    $directoryPath = Storage::path('/Image_category');
                    // dd($directoryPath);
                    if (!file_exists($directoryPath)) {
                        mkdir($directoryPath, 0755, true);
                    }

                    $outputPath =  $directoryPath . '/' . $actualname . '.jpeg';
                    // dd($outputPath);
                    $resizedImage->writeImage($outputPath);

                    // Clean up memory
                    $image->destroy();
                    $resizedImage->destroy();

                    // Generate a unique filename for download
                    $newname = $actualname . '_' . time() . '.jpeg';
                    $headers = ['Content-Type: image/jpeg',
                    'Content-Disposition' => 'attachment; filename="' . $actualname . '.jpeg"'  // Force download with the actual name
                    ];
                    // $down=response()->download($outputPath,$newname,$headers);
                    // dd($down);
                    return response()->download($outputPath,$newname,$headers);
                } catch (Exception $e) {
                    return back()->with('error', 'An error occurred while processing the image: ' . $e->getMessage());
                }
            case 'svg':
                    if ($url == null) {
                        return back()->with('error', 'Image URL is required');
                    }

                    if (!filter_var($url, FILTER_VALIDATE_URL)) {
                        return back()->with('error', 'Invalid Image URL');
                    }

                    try {

                        $contents = @file_get_contents($url);
                        if ($contents === false) {
                            return back()->with('error', 'Failed to retrieve image from URL');
                        }
                        if ($color && strpos($contents, '<svg') !== false) {
                            // Parse the SVG content and replace colors
                            $dom = new DOMDocument();
                            libxml_use_internal_errors(true); // Suppress parsing errors for invalid SVG
                            $dom->loadXML($contents);
                            libxml_clear_errors();

                            // Change the `fill` or `stroke` attributes to the desired color
                            $svgElements = $dom->getElementsByTagName('svg');
                            if ($svgElements->length > 0) {
                                $svgElement = $svgElements->item(0);
                                $svgElement->setAttribute('fill', $color); // Replace the color
                            }

                            $pathElements = $dom->getElementsByTagName('path');
                            foreach ($pathElements as $path) {
                                $path->setAttribute('fill', $color); // Replace `fill` color
                                $path->setAttribute('stroke', $color); // Replace `stroke` color if needed
                            }

                            $contents = $dom->saveXML();
                        }

                        $name = basename(parse_url($url, PHP_URL_PATH));
                        $actualname = pathinfo($name, PATHINFO_FILENAME);
                        // dd($actualname);
                        // Create a new Imagick instance
                        // $image = new Imagick();
                        // $image->readImageBlob($contents);  // Read the SVG contents directly

                        // // Optional: You can resize the SVG if needed
                        // $image->resizeImage($active_txt, $active_txt, Imagick::FILTER_LANCZOS, 1);

                        // Ensure directory exists
                        $directoryPath = Storage::path('/svg');

                        if (!file_exists($directoryPath)) {
                            mkdir($directoryPath, 0755, true);
                        }

                        $outputPath =  $directoryPath . '/' . $actualname . '.svg';
                        // $image->writeImage($outputPath);  // Save the image as SVG
                        // dd($outputPath);
                        // // Clean up memory
                        // $image->destroy();

                        // Save the SVG content
                        file_put_contents($outputPath, $contents);
                        // Generate a unique filename for download
                        $newname = $actualname . '_' . time() . '.svg';
                        $headers = ['Content-Type: image/jpeg',
                        'Content-Type' => 'image/svg+xml', // Adjust the MIME type if necessary
                        'Content-Disposition' => 'attachment; filename="' . $newname . 'svg' // Force download with the actual name
                        ];

                        return response()->download($outputPath, $newname, $headers);

                    } catch (Exception $e) {
                        return back()->with('error', 'An error occurred while processing the image: ' . $e->getMessage());
                    }
            }
    }

    public function copylink(Request $request){
        $url = $request->query('imgUrl');
        $active_txt = (int) $request->query('active_txt');
        $color = $request->query('color');

        if (!$url) {
            return response()->json(['error' => 'Image URL is required'], 400);
        }

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return response()->json(['error' => 'Invalid Image URL'], 400);
        }

        try{
            $contents = @file_get_contents($url);
            if ($contents === false) {
                return response()->json(['error' => 'Failed to retrieve image from URL'], 400);
            }
            if ($color && strpos($contents, '<svg') !== false){
                $dom = new DOMDocument();
                    libxml_use_internal_errors(true); // Suppress parsing errors for invalid SVG
                    $dom->loadXML($contents);
                    libxml_clear_errors();

                            // Change the `fill` or `stroke` attributes to the desired color
                    $svgElements = $dom->getElementsByTagName('svg');
                    if ($svgElements->length > 0) {
                        $svgElement = $svgElements->item(0);
                        $svgElement->setAttribute('fill', $color); // Replace the color
                    }

                    $pathElements = $dom->getElementsByTagName('path');
                    foreach ($pathElements as $path) {
                        $path->setAttribute('fill', $color); // Replace `fill` color
                        $path->setAttribute('stroke', $color); // Replace `stroke` color if needed
                    }

                    $contents = $dom->saveXML();
            }
            $name = basename(parse_url($url,PHP_URL_PATH));
            $actualname = pathinfo($name, PATHINFO_FILENAME);

            $directorypath = storage_path('app/public/copylink');
            if (!file_exists($directorypath)) {
                mkdir($directorypath, 0755, true);
            }
            $timestamp = now()->format('Ymd_His');
            $outputpath = $directorypath . '/' . $actualname . '-' . $timestamp . '.svg';

            file_put_contents($outputpath,$contents);

            $publicurl = asset('storage/copylink/' . $actualname . '-' . $timestamp . '.svg');
            return response()->json(['copy_link' => $publicurl], 200);
        }
        catch(Exception $e){
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function fetch_svg(Request $request){
        $iconUrl = $request->query('url');
        $response =  @file_get_contents($iconUrl);
        if ($response !== false) {
            return response($response, 200)
                ->header('Content-Type', 'image/svg+xml');
        }

        return response("Failed to fetch SVG", 500);
    }

    public function incrementViewCount(Request $request){
        $iconName = $request->input('iconName');
        // Find the icon by name and increment the view count
        $icon = Icon::where('icon_name', $iconName)->first();
        if ($icon) {
            $icon->view_counts += 1;
            $icon->save();
            $updatedCount = $icon->view_counts; // Get the updated view count
            return response()->json(['message' => 'View count updated successfully.','view_count' => $updatedCount], 200);
        } else {
            return response()->json(['message' => 'Icon not found.'], 404);
        }
    }

    public function incrementDownloadCount(Request $request)
    {
        $icon_name = $request->input('iconname');
        // dd($icon_name);
        $format = $request->input('format');

        // Find the image by its URL or other unique identifier
        $icon = Icon::where('icon_name', $icon_name)->first();

        if ($icon) {
            // Increment the download count
            $icon->download_counts++;
            $icon->save();

            $updatedDownloadcount = $icon->download_counts;

            return response()->json(['message' => 'Download count updated successfully','downloadcount'=>$updatedDownloadcount]);
        }

        return response()->json(['message' => 'Icon not found'], 404);
    }

    public function storeUserDetails(Request $request)
    {
        $ip = request()->ip();
        $apiKey = '6682e351-2110-4437-a88e-4035c17d0177';

        if ($ip === '127.0.0.1' || $ip === '::1') {
            $location = 'Localhost';
        } else {
            $response = Http::get("http://ipinfo.io/{$ip}/json?token={$apiKey}");

            if ($response->successful()) {
                $location = $response->json('city') . ', ' . $response->json('country');
            } else {
                $location = 'Unknown';
            }
        }

        // Create a new user session and store it in the database
        $session = UserSession::create([
            'ip_address' => $ip,
            'location' => $location,
            'session_id' => $request->sessionId,
            'in_time' => now(),
        ]);


        return response()->json(['status' => 'success']);
    }


    public function storeOutTime(Request $request)
{

    UserSession::where('session_id', $request->sessionId)
        ->update(['out_time' => now()]);

    return response()->json(['message' => 'Logout time stored successfully']);
}


}
