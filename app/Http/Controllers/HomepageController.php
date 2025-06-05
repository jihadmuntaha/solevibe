<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Categories;
use App\Models\Theme;

class HomepageController extends Controller
{
    private $themeFolder;

    public function __construct()
    {
        $theme = Theme::where('status', 'active')->first();
        if ($theme) {
            $this->themeFolder = $theme->folder;
        } else {
            $this->themeFolder = 'default';
        }
    }

    public function index()
    {
        $categories = Categories::latest()->take(4)->get();
        
        return view($this->themeFolder.'.homepage',[
            'categories' => $categories,
            'title'=>'Homepage'
        ]);
    }

    public function products()
    {
        $title = "Products";

        return view($this->themeFolder.'.products',[
            'title'=>$title
        ]);
    }

    public function product($slug){
        return view($this->themeFolder.'.product', [
            'slug' => $slug
        ]);
    }

    public function categories()
    {
        return view($this->themeFolder.'.categories',[
            'title'=>'Categories'
        ]);
    }

    public function category($slug)
    {
        $category = Categories::find($slug);

        return view($this->themeFolder.'.category_by_slug', [
            'slug' => $slug, 
            'category' => $category
        ]);
    }

    public function cart()
    {
        return view($this->themeFolder.'.cart',[
            'title'=>'Cart'
        ]);
    }

    public function checkout()
    {
        return view($this->themeFolder.'.checkout',[
            'title'=>'Checkout'
        ]);
    }
}
