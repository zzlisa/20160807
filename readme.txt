19��̨��¼ģ������
    ��sever.php������Ϊindex.php
    ��public�ļ����е�.htaccess�ļ����뵽blog�ļ�����
	(����������)
	�������ݿ�ǰ׺  config->database.php ����ǰ׺ 'prefix' => env('DB_PREFIX', ''),
	��.env�м���DB_PREFIX=blog_
	�½��������������ݿ�  ��������DB::�������ռ�use Illuminate\Support\Facades\DB
	�½����ݿ⣬�޸�.env�ļ�
	
	����̨��¼ҳ�棬����login·�ɣ��½�login������������admin�ļ�����
	�̳е�controller�½�һ�����õĿ�����
	common������ use App\Http\Controllers\Controller; �޸������ռ�
	login��������view(admin.login)
	��ģ���ļ�����views�ļ����� ��login.html������Ϊlogin.blade.php
	�޸�css·��{{asset(·������)}}

20������֤���༰session����
    
	������֤��·��   ���������·��
	reaources�ļ����½�һ��org�ļ��У�������֤��
	����֤�����뵽login��������  require_once 'resources/org/code/Code.class.php';
	������֤���е�code����   $code = new \Code;�����ռ�δ���أ�����'\'��ʾȥ��ײ���
	������ļ�index.php�п���session   session_start();
	����֤����õ�loginģ���� {{url('admin/code')}}
	<img src="{{url('admin/code')}}" alt="" onclick="this.src='{{url('admin/code')}}?'+Math.random()">
	ÿ�ε��ˢ�� ��һ��onclick

21��¼���ύcsrf��֤����֤���ж�
    ��Input::��������ȡ�ύ������ �����IS_POST()����  �����ռ䣺use Illuminate\Support\Facades\Input;
	{{csrf_field()}} ��login.blade.php�м���csrf��tokenֵ
	���ص�ǰҳ��back();
	��֤��֤�룬�浽��session,��Ҫ����֤
	        @if(session('msg'))
			<p style="color:red">{{session('msg')}}</p>
			@endif
			��֤��֤��
            $code = new \Code;
            $_code = $code->get();
            if($input['code'] != $_code){
                return back()->with('msg', '��֤�����');
            }
	strtoupper()���������ĸת��Ϊ��д��ĸ��ʹ��֤�����벻�����ִ�Сд

22��̨��¼����crypt���ܺͽ���
    ����·��crypt
	����Crypt::  �����ռ�:use Illuminate\Support\Facades\Crypt;
	������ܣ�ץȡһ�μ��ܽ���Ϳ��Խ��н���
	eyJpdiI6IkVuZ3FnZHNPWmUzQlpzcHZhSE0rTkE9PSIsInZhbHVlIjoiSHIwMkxIWStJ
	QkxVdWhCTHR0ckJ1dz09IiwibWFjIjoiMTlhMWEyYzhiY2I4NTEwOGQyZmIwNDJiMDM4
	ZTkzNTI2NmMzNjNkOWMzN2ZkYjQyMDlhYzA3MDA2ZWU5YTJjOSJ9
	Crypt::encrypt����   Crypt::decrypt����
	�������ݱ� user_id user_name user_pass
	��¼��Ҫ�����ݿ�Խӣ���Ҫmodel ɾ�����е�user.php
	����model   php artisan make:model User
	����һ��Model�ļ��У���Controller����ͬһ��Ŀ¼  ��Userģ�ͷŵ��ļ���
	�޸������ռ�  namespace App\Http\Model;
	User::all();ȡ���ݱ��е���������
	������֤Ҫ�Ƚ���  Crypt::decrypt($user->user_pass) != $input['user_pass'])
	����¼��Ϣд��session��������ҳ��Ҳ����ʶ����Ϣ
	session(['user'=>$user]);
	
23��̨��ҳ����ӭҳ���޸ļ�����ͼ����
    ����·��index
	����ģ�� index.blade.php  ���õ�ַiframe src="{{url('admin/info')}}"
	����ϵͳ  {{PHP_OS}}
	���л���  {{$_SERVER['SERVER_SOFTWARE']}}
	����ʱ��  <?php echo date('Y��m��d�� Hʱi��s��')?>
	����һ�㶼��config�ļ���,�޸�ʱ����Ҫ�޸����� app.php�½�ʱ����Ϊ'timezone' => 'PRC',
	����������/IP  {{$_SERVER['SERVER_NAME']}}
	Host  {{$_SERVER['SERVER_ADDR']}}
	����ҳ���Ӹ�Ϊ{{url('admin.info')}}
	@yield('content')Ϊ����ͼ�滻������   �½�һ��ģ��admin.blade.php��ͷβ���ƹ���
	@extends('layouts.admin')//�̳�
	@section('content')//�����滻���������
	@endsection
	redirect()��ʾ��ת

24��̨����Ա��¼�м�����ú�ע����¼
    �����м������index��info·�ɷŽ�·��Ⱥ��
	��ע��һ����admin.login  ��kernel.php��ע��һ���м��
	�ٴ���һ���м��
	���м�����ж�session�Ƿ������� ͬʱ��Ҫ��login���������������session  session(['user'=>null]);
	���session�Ĺ��̾����˳��Ĺ��� �˳�����
	�ֲ�·�ɣ������˳�
	
25��̨��������Ա��¼�����޸ļ�validation��֤
    ·�ɾ�����Ҫȫ��any  ��pass·�ɷ��䵽index������
	����pass��������pass.html������Ϊpass.blade.php���Ҽ̳�����ͼ
	��pass�����н����ж�  ��Input::���������жϣ���all()
	д��csrf��֤�����ύ������Ϊaction
	��֤��Validator::������� Validator����make()��������һ���������ύ������
	�ڶ�����������֤����  ��������������ʾ��Ϣ(��Ҫ�Լ�д)
	'password'=>'required',���벻��Ϊ��
	���$validator�е�passes����ͨ��������Ϊ�棬���򣬷���Ϊ��
	use Illuminate\Support\Facades\Validator;
	$validator->errors()->all()�鿴���д���
	confirmedƥ������Ĭ�ϵĹ���  ��Ҫ�޸�Ϊpassword_confirmation
	���������ʾ������Ϣ�����ص�ҳ�棬��Ҫ��ҳ�����
	tab.htmlģ���ļ�����һ��ר������ʾ��Ϣ��
	�ж�ԭ���벢����
	
26���ݿ����·����Ĵ���
    ԭ�����������ʱ�ᱨ����Ҫ����  ����������Ƕ���all()�����������������ַ�����ֱ�����
	���ݿ����·���
	cate_id cate_name cate_title cate_keywords cate_description cate_view cate_order cate_pid 
	
27��̨���·����б�ҳģ�嵼�뼰������Ϣչʾ
    ���·���Ӧʹ����Դ·��
|        | POST                           | admin/category                 | admin.category.store   | App\Http\Controllers\Admin\CategoryController@store   | 
web,web,admin.login |
|        | GET|HEAD                       | admin/category                 | admin.category.index   | App\Http\Controllers\Admin\CategoryController@index   | 
web,web,admin.login |
|        | GET|HEAD                       | admin/category/create          | admin.category.create  | App\Http\Controllers\Admin\CategoryController@create  | 
web,web,admin.login |
|        | GET|HEAD                       | admin/category/{category}      | admin.category.show    | App\Http\Controllers\Admin\CategoryController@show    | 
web,web,admin.login |
|        | DELETE                         | admin/category/{category}      | admin.category.destroy | App\Http\Controllers\Admin\CategoryController@destroy | 
web,web,admin.login |
|        | PUT|PATCH                      | admin/category/{category}      | admin.category.update  | App\Http\Controllers\Admin\CategoryController@update  | 
web,web,admin.login |
|        | GET|HEAD                       | admin/category/{category}/edit | admin.category.edit    | App\Http\Controllers\Admin\CategoryController@edit    | 
web,web,admin.login |

�ڿ������зֱ�����Ӧ�ķ���
php artisan route:list�鿴����·��  �����ݿ�Խӣ���Ҫ����һ��ģ��
Category::use App\Http\Model\Category;
�����ݿ���������ݣ��ֱ�����ҳ��

28��̨���·���ҳ�༶�����б�
    ���������Ŀ������pid���븸��id��Ӧ
	�½�һ���������з���
	��һ��:��ӡ��cate_name �½����飬�ҳ�cate_pid=0������  ���ڶ��α�����pid���һ����ͬ�ķ���һ��
	��data����ҳ����  $data[$m]["_cate_name"]ǰ�߼���_��ʾ�Զ�����ֶ�
	���ຯ��getTree()   �ݹ�������Լ�ȥ���ԡ�����
	��ĿҪ��ֲ����Ҫ��һЩͨ�õ����� ��һ��Ĭ��ֵ
	 public function getTree($data, $field_name, $field_id='id', $field_pid='pid', $pid=0){
        
        $arr = array();
        
        foreach($data as $k=>$v){
            if($v->$field_pid==$pid){
                
                $data[$k]["_".$field_name] = $data[$k][$field_name];
                $arr[] = $data[$k];
                foreach($data as $m=>$n){
                    if($n->$field_pid == $v->$field_id){
                        
                        $data[$m]["_".$field_name] = '��-- '.$data[$m][$field_name];
                        $arr[] = $data[$m];
                    }
                }
            }
        }
        return $arr;
    }
	��������Ϳ�����ֲ�ˡ�����
	����������ģ�ͺ���ͼ֮��ĶԽ�  ģ���Ǵ������ݵģ�����Ӧ����ģ����
	������������һ���ศ��ɵĹ���
	
29��̨���·���ҳAjax�첽�޸ķ�������
    layer.layui.com
	����ʧ�ܡ�����
	�����޷����������
	
30��̨���·������ģ����估��������Ƕ��
    �����С�����
	
31��̨���·����������Validation��֤�����
    ��������ӵ����ݿ� ֻ��token����Ҫ��������input all()��������except����
	��ܶԱ��ύ��������һ��������ʩ
	protected $guarded = [];  �ų����������ֶΣ���model���޸�
	fillable �����ֶ�  ��ȡҳ��ľ���ֵ
	<input type="hidden" name="method" value="put"> ���ύ��put����
	
32��̨���·���༭��ģ��PUT�����ύ��
    ɾ����������ʱ������ɾ���Ӽ�
	
34���ݿ����±�Ĵ������������ģ�嵼��
	art_title
	art_tag
	art_description
	art_thumb
	art_content
	art_time
	art_editor
	art_view
	�����������ģ�壬ͬ��ӷ���ģ��
	
35��̨������Ӽ��ٶȱ༭��UeditorǶ��
    ueditor�༭����ʽ����
	<style>
		.edui-default{
			line-height:28px;
		}
		div .edui-combox-body, div .edui-button-body, div .edui-splitbutton-body{
		    overflow:hidden;
			height:20px;
		}
		div .edui-box{
			overflow:hidden;
			height:22px;
		}
	</style>
	
36��̨�����������ͼ�ϴ�֮uploadify������롢
	ճ��һ���Ҳ�֪���Ķ���
	<script src="{{asset('resources/org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
                        <link rel="stylesheet" type="text/css" href="{{asset('resources/org/uploadify/uploadify.css')}}">
                        <script type="text/javascript">
                            <?php $timestamp = time();?>
                            $(function() {
                                $('#file_upload').uploadify({
                                    'formData'     : {
                                        'timestamp' : '<?php echo $timestamp;?>',
                                        'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
                                    },
                                    'swf'      : "{{asset('resources/org/uploadify/uploadify.swf')}}",
                                    'uploader' : "{{asset('resources/org/uploadify/uploadify.php')}}"
                                });
                            });
                        </script>
						
	��ʽ΢������:
	<style>
		.uploadify{
			display:inline-block;
		}
		.uploadify-button{
			border:none;
			border-radius:5px;
			margin-top:8px;
		}
		table .add_tab tr td span .uploadify-button-text{
			color:#fff;
			margin:0;
		}
	</style>
	
	����ͼ�ϴ�����д��common��������
	���ϴ�·���ĳ��Լ��ĵ�ַ
	
37��̨�����������ͼ�ϴ�֮�ļ��洢
	$newName = date('YmdHis').mt_rand(100,999);
	 //ͼƬ�ϴ�
    public function upload(){

    	$file = Input::file('Filedata');
    	//�ж��ϴ��ļ��Ƿ���Ч
    	if($file->isValid()){
    		$realPath = $file -> getRealPath(); //��ȡ��ʱ�ļ��ľ���·��
    		$entension = $file -> getClientOriginalExtension(); //�ϴ��ļ��ĺ�׺

    		$newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
    		//201608020000123.jpg
    		$path = $file -> move(base_path().'/uploads', $newName);//�ļ��ƶ���������

    		echo $path;
    	}
    }
	�½�һ��uploads�ļ���
	ͼƬ·������·��û�����������
	
38��̨����������ݼ�Validation��֤
	�������ݿ⣬��Ҫ�½�ģ��
	
39��̨����ҳ�б�չʾ����ҳ����ʵ��
	��ȡ��ҳ��Ϣ
	$data = Article::paginate(10);
    return view('admin.article.index', compact('data'));
	
40��̨���±༭
	������ʵ��ķ�ʽ�������  {!!$field->art_content!!}
	
41��̨����ɾ��

42��������ģ��ʹ��Migrations���ݿ�Ǩ�ƴ������ݱ�
	link_id
	link_name
	link_title
	link_url
	link_order
	����һ�����������ļ�
	php artisan make:migration create_links_table
	�������ݿ�Ǩ���ļ�
	public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->engine('MyISAM');
            $table->increments('link_id');
            $table->string('link_name')->default('')->comment('����'); //varchar
            $table->string('link_title')->default('')->comment('����');
            $table->string('link_url')->default('')->comment('����');
            $table->string('link_order')->default('0')->comment('����');
        });
    }
	
43��������ģ��ʹ��Seeding����������
	�������������  php artisan make:seeder UsersTableSeeder
	
44��������ģ���б�ҳ��չʾ��Ajax�첽�޸�����
	�첽�޸�����Ϊʲô����ʧ�ܣ�
	
45�����������

46���������޸ļ�ɾ��

47����������ģ�����������Զ��嵼��ģ��

48��վ����ģ����������ݱ���
	conf_title
	conf_name
	conf_content
	conf_order
	conf_tips
	field_type
	field_value
	
49�����վ������

50�����ִ��ˡ�����

51�޸�

52��վ����ֵ������ʾ

54������վ�������ļ�
	��������д�������ļ���
	public function putFile(){

        //��ȡ������
        // echo \Illuminate\Support\Facades\Config::get('web.web_title');

        //�����ݿ��ж�ȡ�ļ�
        $config = Config::pluck('conf_content', 'conf_name')->all();//����all������ת�ɴ�����
        //���鲻��ֱ��д���ַ�����������Ҫ������ת��Ϊ�ַ���var_export()
        //1.������ת��Ϊ�ַ�����2.ֱ�Ӹ�ֵ
        // echo var_export($config, true);
        //�ҵ��ļ�·������Ҫ�Ӹ�Ŀ¼��ʼ��
        $path = base_path().'\config\web.php';
        //������д��·��file_put_contents();
        $str='<?php return '.var_export($config, true).';';
        file_put_contents($path, $str);
        //echo $path;
    }
	
55С�汾����
	��web�м��Ĭ������Ϊȫ�ֵ�,����Ҫ�Լ��ظ�����
	session csrf��֤(postmanģ��post�ύ��ʱ������)
	session(return back()->with('msg','xxxx'))
	
58��Ҫ�ڿ������ж�ȡ�Զ��嵼��
