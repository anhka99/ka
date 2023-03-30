<?php
return array (
  51 => 
  array (
    'id' => 51,
    'name' => '行业企业',
    'dirname' => 'company',
    'urlrules' => 'a:6:{s:4:"list";a:6:{s:7:"tplfile";s:4:"list";s:5:"rules";s:18:"newslist/{pinyin}/";s:10:"rules_page";s:25:"newslist/{pinyin}/{page}/";s:6:"system";s:1:"1";s:8:"pagetype";s:1:"1";s:7:"tplname";s:15:"列表页模板";}s:4:"show";a:6:{s:7:"tplfile";s:4:"show";s:5:"rules";s:14:"html/{id}.html";s:10:"rules_page";s:0:"";s:6:"system";s:1:"1";s:8:"pagetype";s:1:"2";s:7:"tplname";s:15:"内容页模板";}s:12:"product_list";a:6:{s:7:"tplfile";s:12:"product_list";s:5:"rules";s:26:"product_list/{pinyin}.html";s:10:"rules_page";s:33:"product_list/{pinyin}/{page}.html";s:6:"system";s:1:"1";s:8:"pagetype";s:1:"1";s:7:"tplname";s:15:"产品列表页";}s:12:"product_show";a:6:{s:7:"tplfile";s:12:"product_show";s:5:"rules";s:17:"product/{id}.html";s:10:"rules_page";s:0:"";s:6:"system";s:1:"1";s:8:"pagetype";s:1:"2";s:7:"tplname";s:15:"产品内容页";}s:7:"contact";a:6:{s:7:"tplfile";s:7:"contact";s:5:"rules";s:33:"contact/,contact.html,lianxi.html";s:10:"rules_page";s:0:"";s:6:"system";s:1:"1";s:8:"pagetype";s:1:"0";s:7:"tplname";s:15:"联系我们页";}s:5:"about";a:6:{s:7:"tplfile";s:5:"about";s:5:"rules";s:26:"about/,aboutus/,about.html";s:10:"rules_page";s:0:"";s:6:"system";s:1:"1";s:8:"pagetype";s:1:"0";s:7:"tplname";s:15:"关于我们页";}}',
    'tplrules' => '10',
    'tplfiles' => 'list,show,product_list,product_show,contact,about',
    'musttpl' => 'index,list,show',
    'pagetype' => '',
    'system' => '1',
    'params' => '',
    'addfields' => '',
    'notes' => '',
    'temp' => '',
    'temp2' => '',
  ),
  52 => 
  array (
    'id' => 52,
    'name' => '文章资讯',
    'dirname' => 'news',
    'urlrules' => 'a:2:{s:4:"list";a:6:{s:7:"tplfile";s:4:"list";s:5:"rules";s:9:"{pinyin}/";s:10:"rules_page";s:16:"{pinyin}/{page}/";s:6:"system";s:1:"1";s:8:"pagetype";s:1:"1";s:7:"tplname";s:15:"列表页模板";}s:4:"show";a:6:{s:7:"tplfile";s:4:"show";s:5:"rules";s:29:"html/{id}.html,news/{id}.html";s:10:"rules_page";s:0:"";s:6:"system";s:1:"1";s:8:"pagetype";s:1:"2";s:7:"tplname";s:15:"内容页模板";}}',
    'tplrules' => '10',
    'tplfiles' => 'list,show',
    'musttpl' => 'index,list,show',
    'pagetype' => '',
    'system' => '1',
    'params' => '',
    'addfields' => '',
    'notes' => '',
    'temp' => '',
    'temp2' => '',
  ),
  83 => 
  array (
    'id' => 83,
    'name' => '淘宝客',
    'dirname' => 'taoke',
    'urlrules' => 'a:4:{s:4:"list";a:6:{s:7:"tplfile";s:4:"list";s:5:"rules";s:22:"newslist/{pinyin}.html";s:10:"rules_page";s:29:"newslist/{pinyin}-{page}.html";s:6:"system";s:1:"1";s:8:"pagetype";s:1:"1";s:7:"tplname";s:15:"列表页模板";}s:4:"show";a:6:{s:7:"tplfile";s:4:"show";s:5:"rules";s:14:"news/{id}.html";s:10:"rules_page";s:0:"";s:6:"system";s:1:"1";s:8:"pagetype";s:1:"2";s:7:"tplname";s:15:"内容页模板";}s:5:"goods";a:6:{s:7:"tplfile";s:5:"goods";s:5:"rules";s:15:"goods/{id}.html";s:10:"rules_page";s:0:"";s:6:"system";s:1:"1";s:8:"pagetype";s:1:"2";s:7:"tplname";s:15:"商品内容页";}s:9:"goodslist";a:6:{s:7:"tplfile";s:9:"goodslist";s:5:"rules";s:23:"goodslist/{pinyin}.html";s:10:"rules_page";s:30:"goodslist/{pinyin}-{page}.html";s:6:"system";s:1:"1";s:8:"pagetype";s:1:"1";s:7:"tplname";s:21:"商品列表页模板";}}',
    'tplrules' => '',
    'tplfiles' => 'list,show,goods,goodslist',
    'musttpl' => '',
    'pagetype' => '',
    'system' => '1',
    'params' => '',
    'addfields' => 'price
itemid',
    'notes' => '商品的附加数据字段为 价格、商品id。商品栏目需要自定义文章信息库。
导入txt格式：标题******缩略图（多个用|连接）******描述******价格******商品id',
    'temp' => '',
    'temp2' => '',
  ),
);
?>