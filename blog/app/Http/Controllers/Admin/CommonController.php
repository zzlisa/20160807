<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
class CommonController extends Controller
{
    //图片上传
    public function upload(){

    	$file = Input::file('Filedata'); //获取文件信息
    	//判断上传文件是否有效
    	if($file->isValid()){
    		$entension = $file -> getClientOriginalExtension(); //上传文件的后缀

    		$newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
    		//201608020000123.jpg
    		$path = $file -> move(base_path().'/uploads/', $newName);//文件移动到指定文件夹后重命名

    		$filepath = 'uploads/'.$newName;
    		return $filepath; //返回当前页面
    	}
    }
}
