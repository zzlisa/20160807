<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Model\Config;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class ConfigController extends CommonController
{
    //get.admin/config 全部配置项列表
    public function index(){

    	$data = Config::orderBy('conf_order', 'asc')->get();
        foreach ($data as $k => $v) {
            switch ($v->field_type) {
                case 'input':
                    $data[$k]->_html = '<input type="text" class="lg" name="conf_content[]" value="'.$v->conf_content.'" />';
                    break;
                case 'textarea':
                    $data[$k]->_html = '<textarea type="text" class="lg" name="conf_content[]">'.$v->conf_content.'</textarea>';
                    break;
                case 'radio':
                    //1 | 开启, 0 | 关闭
                    //explode拆分字符串，第一个参数为按照','拆分，第二个为拆分的字符串
                    $arr = explode(',', $v->field_value);
                    //dd($arr);
                    $str = '';
                    foreach ($arr as $m => $n) {
                        //1 | 开启
                        $r = explode('|', $n);
                        // $c = '';
                        // if($v->conf_content != $r[0])
                        // {
                        //     $c = ' checked ';
                        // }
                        //dd($r);
                        //dd($r[0]);
                        $c = $v->conf_content==$r[0]?' checked ':'';
                        //拼接字符串
                        $str .= '<input type="radio" name="conf_content[]" value="'.$r[0].'"'.$c.'>'.$r[1].'　';
                    }
                    //echo $str;
                    $data[$k]->_html = $str;
                    break;
            }
        }

    	return view('admin.config.index', compact('data'));
    }

    // get.admin/config/create 添加配置项
    public function create(){
   
        return view('admin/config/add');
    }

    // post.admin/config 添加配置项提交
    public function store(){
        
        $input = Input::except('_token');
        
        $rules = [
              'conf_name'=>'required',
              'conf_title'=>'required',
            ];
            
            $message = [
                'conf_name.required' => '配置项名称不能为空',
                'conf_title.required' => '配置项标题不能为空',
            ];
            
            $validator = Validator::make($input,$rules,$message);
            if($validator->passes()){

                $re = Config::create($input);
                if($re){
                    return redirect('admin/config');
                } else{

                    return back()->with('errors','配置项失败，请稍后重试');

                }
                
            } else{
                
                
                return back()->withErrors($validator);
            }
    }

    public function changeContent(){

        $input = Input::all();
        foreach ($input['conf_id'] as $k => $v) {
            Config::where('conf_id', $v)->update(['conf_content'=>$input['conf_content'][$k]]);
        }

        //有更新时调取方法
        $this->putFile();
        return back()->with('errors', '配置项更新成功！');
    }

    public function putFile(){

        //读取配置项
        // echo \Illuminate\Support\Facades\Config::get('web.web_title');

        //从数据库中读取文件
        $config = Config::pluck('conf_content', 'conf_name')->all();//加上all方法，转成纯净的
        //数组不能直接写到字符串，首先需要把数组转化为字符串var_export()
        //1.将数组转化为字符串，2.直接赋值
        // echo var_export($config, true);
        //找到文件路径，需要从根目录开始找
        $path = base_path().'\config\web.php';
        //将内容写到路径file_put_contents();
        $str='<?php return '.var_export($config, true).';';
        file_put_contents($path, $str);
        //echo $path;
    }

    public function changeOrder(){
        
        $input = Input::all();
        
        $config = Config::find($input['conf_id']);
        $config->conf_order = $input['conf_order'];
        $re = $config->update();
        
        if($re){
            $data = [
                'status' => 0,
                'msg' => '配置项排序更新成功!',
            ];
        } else{
            $data = [
                'status' => 1,
                'msg' => '配置项排序更新失败,请稍后重试!',
            ];
        }
        
        return $data;
        
    }

    // get.admin/config/{config}/edit 编辑配置项
    public function edit($conf_id){
        $field = Config::find($conf_id);
        return view('admin.config.edit', compact('field'));
    }

     // put.admin/config/{config} 更新配置项
    public function update($conf_id){
        $input = Input::except('_token','_method');
        $re = Config::where('conf_id', $conf_id)->update($input);

        if($re){

            $this->putFile();
            return redirect('admin/config');
        } else{
            return back()->with('errors','配置项更新失败，请稍后重试！');
        }
    }

    public function show(){

    }

    // delete.admin/config 删除配置项
    public function destroy($conf_id){
        
        $re = Config::where('conf_id', $conf_id)->delete();

        if($re){
            $this->putFile();
            $data = [
                'status' => 0,
                'msg' => '配置项删除成功！'
            ];
        } else{

            $data = [
                'status' => 1,
                'msg' => '配置项删除失败，请稍后重试！'
            ];
        }
        return $data;
    }
}
