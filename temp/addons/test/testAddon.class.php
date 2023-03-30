<?php
//加入这句防止外部访问
!defined('INI_XXFSEO') && exit('Access Denied');

/*
可获取的部分系统参数

常量：
IS_ROBOT		是否蜘蛛访问
ROBOT_NAME	蜘蛛类型
IS_MIP		当前模板是否MIP模板
IS_MOBILE	是否手机访问
IS_CACHED	是否已缓存页面
CACHE_FILE	缓存页面文件路径

变量：
$GLOBALS['thisurl']		当前页面url地址
$GLOBALS['domain_id']	 当前网站分组ID
$GLOBALS['domain_cid']	当前网站所属模型ID
$GLOBALS['domain_dirname']	当前网站分组文件夹
$GLOBALS['domain_config']	当前网站分组配置
$GLOBALS['arctype_config']	当前网站所属模型配置
$GLOBALS['arctype_dirname']	当前模型文件夹
$GLOBALS['catelog_this']		当前栏目信息
$GLOBALS['catelog_parent']	父栏目信息
$GLOBALS['reform_config']	当前网站优化配置
$GLOBALS['html']				网页html，供before_show钩子调用和修改
$this->config		当前插件的自定义配置

函数：
config();						获取所有配置
config('xxx');					获取配置xxx的值
config('web_theme');		获取当前模板文件名
config('xxx','xxxx');		赋值，xxx可用于模板调用，变量为$xxx，值为xxxx
send_http_status(404);	返回404状态码

*/
class testAddon extends addon{
	//插件信息
    public $info=array(
        'title' => '测试插件',	//插件名称
        'description' => '测试插件描述',	//插件的描述
        'author' => '小旋风seo',	 //作者
        'version' => '1.0',	//插件版本
		'cms_type'=> 'zhizhuchi',	 //支持的程序类型，蜘蛛池为：zhizhuchi，泛目录站群为：mulu 多个逗号分隔
    );
	//设置修改模板数据，前台模板中调用，模板渲染前执行，修改数组$GLOBALS['return_data'] 即可,$data为当前系统已设置的可调用数据
	//注：这里设置的数据并不会写入缓存
	public function set_data($data){
		//获取toptitle，即对应后台《TKD调用模板》中的的title模板
		$toptitle=$data['toptitle'];
		//获取当前文章标题
		$title=$data['title'];
		//获取当前文章内容
		$body=$data['body'];
		//获取其他内容...，自行dump(); 输出
		//替换当前标题，通常toptitle和title都要替换，因为模板中默认是调用toptitle作为title标签
		$toptitle='test_'.$toptitle;
		$title='test2_'.$title;
		$GLOBALS['return_data']=array(
			'调用变量'=>'调用值',
			'toptitle'=>$toptitle,
			'title'=>$title,
			'body'=>$body,
		);
	}
	//设置修改loop标签的数据，设置 $GLOBALS['return_data'] 的值即可变成新数据，此处值为数组
	//$args=array($params,$data)，其中$params当前loop的参数，$data为数据
	public function loop_data($args){
		if(!$args){
			return false;
		}
		list($params,$data)=$args;
		$GLOBALS['return_data']=array();
	}
	//设置修改采集的数据，设置 $GLOBALS['return_data'] 的值即可变成新数据，此处值为字符串或者数组
	//$args=array($type,$data,$rules)，其中$type当前采集的类型，$data为数据，,$rules为当前采集规则
	public function collect_data($args){
		if(!$args){
			return false;
		}
		list($type,$data,$rules)=$args;
		//采集类型为标题，data为数组
		if($type=='title'){
			
		}
		//采集类型为内容，data为字符串
		if($type=='body'){
			//句子模式
			if($rules['split']){
				
			//整篇文章模式
			}else{
				
			}
		}
		//采集类型为栏目名称，data为数组
		if($type=='typename'){
			
		}
		//采集类型为图片地址，data为数组
		if($type=='pic'){
			
		}
		$GLOBALS['return_data']='';
	}
	//程序载入时执行，在程序进行复杂运算之前执行
	public function load_home(){
		//exit('load_home');
		return false;
	}
	//页面缓存前执行
	public function before_cache(){
		
	}
	//模板渲染前执行
	public function before_show(){
		
	}
	//模板渲染后执行
	public function after_show(){
		//echo CACHE_FILE;
	}
}
?>