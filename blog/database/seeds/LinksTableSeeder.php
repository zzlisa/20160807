<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //插入数据
        $data = [
	        [
	            'link_name' => '郑州师范学院',
	            'link_title' => '国内最好的学校',
	            'link_url' => 'http://www.baidu.com',
	            'link_order' => '1',
	        ],
	        [
	        	'link_name' => '没啥说了',
	            'link_title' => 'title是啥',
	            'link_url' => 'http://www.baidu.com',
	            'link_order' => '2',
	        ]
        ];
        DB::table('links')->insert($data);
    }
}
