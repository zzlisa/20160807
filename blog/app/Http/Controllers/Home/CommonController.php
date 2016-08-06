<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Model\Navs;
use App\Http\Model\Article;
use App\Http\Requests;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    public function __construct(){

    	//点击量最高的6篇文章
    	$hot = Article::orderBy('art_view', 'desc')->take(5)->get();

    	//8篇最新发布文章
    	$new = Article::orderBy('art_time', 'desc')->take(8)->get();

    	$navs = Navs::orderBy('nav_order', 'asc')->get();;
    	View::share('navs', $navs);
    	View::share('hot', $hot);
    	View::share('new', $new);
    }
}
