<?php

namespace App\Http\Controllers\Home;
use App\Http\Model\Category;
use App\Http\Model\Article;
use App\Http\Model\Links;

class IndexController extends CommonController
{
    public function index(){

    	
    	//点击量最高的6篇文章
    	//用take方法读取6篇文章(站长推荐区域)
    	$pics = Article::orderBy('art_view', 'desc')->take(6)->get();


    	//图文列表(分页效果)5篇，按时间排列
    	//分页paginate
    	$data = Article::orderBy('art_time', 'desc')->paginate(5);

    	//友情链接
    	$links = Links::orderBy('link_order', 'asc')->get();

    	return view('home.index', compact('pics', 'data', 'links'));
    }

    public function cate($cate_id){

    	//图文列表(分页效果)4篇，按时间排列
    	//分页paginate
    	$data = Article::where('cate_id', $cate_id)->orderBy('art_time', 'desc')->paginate(4);

        //查看次数自增
        Category::where('cate_id',$cate_id)->increment('cate_view');

        //当前分类子分类
        $submenu = Category::where('cate_pid', $cate_id)->get();

    	$field = Category::find($cate_id);
    	return view('home.list', compact('field', 'data', 'submenu'));
    }

    public function article($art_id){
        //读取当前文章信息 join关联查询
        $field = Article::Join('category','article.cate_id','=','category.cate_id')->where('art_id',$art_id)->first();

        //查看次数自增
        Article::where('art_id',$art_id)->increment('art_view');

        $article['pre'] = Article::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();
        $article['next'] = Article::where('art_id','>',$art_id)->orderBy('art_id','asc')->first();

        $data = Article::where('cate_id',$field->cate_id)->orderBy('art_id','desc')->take(6)->get();

        return view('home.new',compact('field','article','data'));
    }
}
