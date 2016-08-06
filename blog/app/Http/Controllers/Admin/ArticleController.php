<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\Category;
use App\Http\Model\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController
{

	//get.admin/article  全部文章列表
    public function index(){

    	$data = Article::orderBy('art_id', 'desc')->paginate(10);
        return view('admin.article.index', compact('data'));
    }

    // get.admin/article/create 添加文章
    public function create(){
        
        $data = (new Category)->tree();

        return view('admin.article.add', compact('data'));
    }

    //post.admin/article  添加文章提交
    public function store(){
    	$input = Input::except('_token');

    	//input里边的art_time就是当前的时间戳
    	$input['art_time'] = time();
    	//验证，如果全部为空则不能提交
    	$rules = [
              'art_title'=>'required',
              'art_content'=>'required',
            ];
            
            $message = [
                'art_title.required' => '文章名称不能为空',
                'art_content.required' => '文章内容不能为空',
            ];
            
        $validator = Validator::make($input,$rules,$message);
            
        if($validator->passes()){

            //通过模型进行入库
		    $re = Article::create($input);
		    if($re){

		        return redirect('admin/article');
		    } else{
		        return back()->with('errors', '数据填充失败,请稍后重试!');
		    }
                
            }else{
                 
                return back()->withErrors($validator);
            }
        }

        // get.admin/article/{article}/edit 编辑文章
    	public function edit($art_id){
        	
        	$data = (new Category)->tree();
        	$field = Article::find($art_id);
        	return view('admin.article.edit', compact('data', 'field'));
    	}

        //更新文章
        public function update($art_id){
            $input = Input::except('_token', '_method');
            $re = Article::where('art_id', $art_id)->update($input);

            if($re){
                return redirect('admin/article');
            } else{
                return back()->with('errors','文章更新失败，请稍后重试！');
            }
        }
        // get.admin/show 显示单个分类信息
        public function show(){
            echo 111;
        }

        
        public function destroy($art_id){
        
            $re = Article::where('art_id', $art_id)->delete();

            if($re){
                $data = [
                    'status' => 0,
                    'msg' => '文章删除成功！'
                ];
            } else{

                $data = [
                    'status' => 1,
                    'msg' => '文章删除失败，请稍后重试！'
                ];
            }
            return $data;
        }

}
