<?php
 function temp_func_362($arg){return '.' . str_replace('$', "\$", $arg[1]); } function temp_func_399($a, $b){return (strLen($a) < strLen($b)); } class template{public $template_dir=''; public $cache_dir=''; public $compile_dir=''; public $cache_lifetime=3600; public $caching=false; public $force_compile=false; public $compile_check=false; public $_foreach=array(); public $_current_file=''; public $_expires=0; public $_nowtime=null; public $_temp_key=array(); public $_temp_val=array(); public $plugins_dir=''; public $replace_compile=array(); public function __construct(){if(!defined('INI_XXFSEO')){define('INI_XXFSEO',true); } $this->_nowtime=time(); $this->template_file=array(); $this->_var=array(); $this->left_delimiter='{'; $this->right_delimiter='}'; } public function assign($tpl_var, $value=''){if(is_array($tpl_var)){foreach($tpl_var AS $key=>$val){if($key != ''){$this->_var[$key]=$val; } } } else{if($tpl_var != ''){$this->_var[$tpl_var]=$value; } } } public function fetch($filename, $cache_id=''){$this->template_dir=rtrim($this->template_dir,'/'); if(strncmp($filename, 'str:', 4) == 0){$file_content=substr($filename, 4); if($this->replace_compile){foreach($this->replace_compile as $k=>$vo){$file_content=str_replace($k,$vo,$file_content); } } $out=$this->_eval($this->fetch_str($file_content)); } else{if(!is_file($filename)){$filename=$this->template_dir. '/' . $filename; } if(!is_file($filename)){return false; } if($cache_id && $this->caching){$out=$this->template_out; } else{if(!in_array($filename, $this->template_file)){$this->template_file[]=$filename; } $out=$this->make_compiled($filename); if($cache_id){$cachename=basename($filename, strrchr($filename, '.')) . '_' . $cache_id; $data=serialize(array('template'=>$this->template_file, 'expires'=>$this->_nowtime + $this->cache_lifetime, 'maketime'=>$this->_nowtime)); $hash_dir=rtrim($this->cache_dir,'/'); if($this->write($hash_dir . '/' . $cachename . '.php', '<?php exit;?>' . $data . $out) === false){trigger_error('can\'t write:' . $hash_dir . '/' . $cachename . '.php'); } $this->template_file=array(); } } } return $out; } public function set_replace_compile($from,$replace){$this->replace_compile[$from]=$replace; } public function make_compiled($filename){$this->compile_dir=rtrim($this->compile_dir,'/'); $name=$this->compile_dir.'/'.md5($filename).'_'.basename($filename) . '.php'; if($this->_expires){$expires=$this->_expires - $this->cache_lifetime; } else{$filestat=@stat($name); $expires=$filestat['mtime']; } $filestat=@stat($filename); $file_change=false; if($this->compile_check){debug_log('compile_check'.$filename); $md5_val=md5_file($filename); $md5data_file=$this->compile_dir.'/md5.php'; $md5_key=md5($filename).'/'.intval($this->compile_check).'/'.basename($filename); if(!is_file($md5data_file)){$file_change=true; $this->write($md5data_file,serialize(array($md5_key=>$md5_val))); }else{$md5_arr=unserialize(get_file($md5data_file,120)); if(!isset($md5_arr[$md5_key]) || $md5_arr[$md5_key]!=$md5_val){$md5_arr[$md5_key]=$md5_val; $file_change=true; $this->write($md5data_file,serialize($md5_arr)); } } debug_log('compile_check'.$filename,'end'); } if(!$file_change && $filestat['mtime']<=$expires && !$this->force_compile){if(file_exists($name)){$source=$this->_require($name); if($source == ''){$expires=0; } }else{$source=''; $expires=0; } } if($file_change || $this->force_compile || $filestat['mtime']>$expires){$this->_current_file=$filename; $file_content=get_file($filename,120); if($this->replace_compile){foreach($this->replace_compile as $k=>$vo){$file_content=str_replace($k,$vo,$file_content); } } $source=$this->fetch_str($file_content); $source='<?php if(!defined(\'INI_XXFSEO\')){define(\'INI_XXFSEO\',true);} ?>'.$source; if($this->write($name, $source) === false){trigger_error('can\'t write:' . $name); } $source=$this->_eval($source); } return $source; } public function fetch_str($source){$source=$this->prefilter_preCompile($source); $source=$this->check_nocache($source); debug_log('compile_tags'); $source=$this->compile_tags($source); debug_log('compile_tags','end'); return $source; } public function compile_tags($source){return preg_replace_callback("/".$this->left_delimiter."(\S[^\}\{\n]*)".$this->right_delimiter."/",array($this,'select'), $source); } public function check_nocache($source){if(!preg_match_all('~\{nocache\}(.*)\{/nocache\}~Us',$source,$match)){return $source; } foreach($match[1] as $k=>$vo){$content=$this->compile_tags($vo); $filename=md5($content).'_nocache.php'; $file=$this->compile_dir.'/'.$filename; if($this->write($file, $content) === false){trigger_error('can\'t write:' . $file); } $newContent='<?php echo $this->_require($this->compile_dir.\'/' .$filename. '\'); ?>'; $source=str_replace($match[0][$k],$newContent,$source); } return $source; } public function is_cached($filename, $cache_id=''){$cachename=basename($filename, strrchr($filename, '.')); if($this->caching == true && $this->direct_output == false){$hash_dir=rtrim($this->cache_dir,'/'); if($data=@file_get_contents($hash_dir . '/' . $cachename . '.php')){$data=substr($data, 13); $pos=strpos($data, '<'); $paradata=substr($data, 0, $pos); $para=@unserialize($paradata); if($para === false || $this->_nowtime > $para['expires']){$this->caching=false; return false; } $this->_expires=$para['expires']; $this->template_out=substr($data, $pos); foreach($para['template'] AS $val){$stat=@stat($val); if($para['maketime'] < $stat['mtime']){$this->caching=false; return false; } } } else{$this->caching=false; return false; } return true; } else{return false; } } public function select($tag){is_array($tag) && $tag=$tag[1]; if($GLOBALS['inNocacheTag'] && $tag!='/nocache' && $GLOBALS['first_compile']){return $this->left_delimiter.$tag.$this->right_delimiter; } if($GLOBALS['inlinktag'] && $tag!='/loop'){return $this->left_delimiter.$tag.$this->right_delimiter; } $tag=stripslashes(trim($tag)); if(empty($tag)){return ''; }else if($tag{0} == '*' && substr($tag, -1) == '*'){return ''; }else if(preg_match('~^(\$[a-zA-Z_\x7f-\xff][\.\w\x7f-\xff]*)([-/\*\+]+)(\d+)$~',$tag,$match)){$str=$this->get_val(substr($match[1], 1)).$match[2].$match[3]; return '<?php echo ('. $str.'); ?>'; }else if(preg_match('~^(\$[a-zA-Z_\x7f-\xff][\.\w\x7f-\xff]*)([\+-/\*]+)(\$[a-zA-Z_\x7f-\xff][\.\w\x7f-\xff]*)$~',$tag,$match)){$arr=preg_split('~([\+-/\*]+)~',$tag,-1,PREG_SPLIT_DELIM_CAPTURE); $str=''; foreach($arr as $k=>$vo){if($k%2==0){$str.=$this->get_val(substr($vo, 1)); continue; } $str.=$vo; } return '<?php echo ('. $str.'); ?>'; }else if($tag{0} == '$'){return '<?php echo ' . $this->get_val(substr($tag, 1)) . '; ?>'; }else if($tag{0} == '/'){switch(substr($tag, 1)){case 'if': return '<?php endif; ?>'; break; case 'foreach': if($this->_foreachmark == 'foreachelse'){$output='<?php endif; unset($_from); ?>'; } else{array_pop($this->_patchstack); $output='<?php endforeach; endif; unset($_from); ?>'; } $output.="<?php \$this->pop_vars(); ?>"; return $output; break; case 'literal': return ''; break; case 'php': return ' ?>'; break; case 'nocache': $GLOBALS['inNocacheTag']=false; return ''; break; default: $plugfile=$this->plugins_dir.'block.'.substr($tag,1).'.php'; if(!$GLOBALS['inlinktag'] && is_file($plugfile)){return '<?php }} ?>'; } if($GLOBALS['inlinktag'] && is_file($plugfile)){$GLOBALS['inlinktag']=false; } return $this->left_delimiter.$tag.$this->right_delimiter; break; } }else if(preg_match('~^(\w+)\(.*\)$~',$tag,$match)){if(function_exists($match[1])){return '<?php echo '.$tag.'; ?>'; } }else if(substr($tag, -1) == '/'){$tag_sel=strpos($tag,' ')>-1?@array_shift(explode(' ', $tag)):substr($tag, 0,-1); $plugfile=$this->plugins_dir.'function.'.$tag_sel.'.php'; if(is_file($plugfile)){$tagfunc='tag_function_'.$tag_sel; $param=$this->get_params(substr($tag, 0,-1), 0); $arrstr='array( '; foreach($param as $k=>$vo){if(substr($vo,0,1)=='$'){$vo='{'.$vo.'}'; } $arrstr.='\''.$k.'\'=>"'.$vo.'", '; } $arrstr.=')'; return '<?php echo $this->'.$tagfunc.'('.$arrstr.'); ?>'; } }else{$tagarr=explode(' ', $tag); $tag_sel=array_shift($tagarr); if($tag_sel=='typename'){$tag_sel='catelog'; } switch($tag_sel){case 'if': return $this->_compile_if_tag(substr($tag, 3)); break; case 'else': return '<?php else: ?>'; break; case 'elseif': return $this->_compile_if_tag(substr($tag, 7), true); break; case 'foreachelse': $this->_foreachmark='foreachelse'; return '<?php endforeach; else: ?>'; break; case 'foreach': $this->_foreachmark='foreach'; if(!isset($this->_patchstack)){$this->_patchstack=array(); } return $this->_compile_foreach_start(substr($tag, 8)); break; case 'assign': $t=$this->get_params(substr($tag, 7), 0); if($t['value']{0} == '$'){if(strpos($t['value'], '+') !== false){preg_match('/\+(\d)+\'\]/', $t['value'], $a); $v1=empty($a[1]) ? 0 : $a[1]; $t['value']=preg_replace('/\+(\d)+/', '', $t['value']); $tmp='$this->assign(\'' . $t['var'] . '\',' . $t['value'] . ' + ' . $v1 . ');'; } else{$tmp='$this->assign(\'' . $t['var'] . '\',' . $t['value'] . ');'; } } else{$tmp='$this->assign(\'' . $t['var'] . '\',\'' . addcslashes($t['value'], "'") . '\');'; } return '<?php ' . $tmp . ' ?>'; break; case 'math': $t=$this->get_math_para(substr($tag, 8)); return'<?php echo ' . $t . '; ?>'; break; case 'include': $t=$this->get_params(substr($tag, 8), 0); return '<?php echo $this->fetch(' . "'$t[file]'" . '); ?>'; break; case 'literal': return ''; break; case 'php': return '<?php '; break; case 'nocache': $GLOBALS['inNocacheTag']=true; return ''; break; default: $plugfile=$this->plugins_dir.'block.'.$tag_sel.'.php'; if(is_file($plugfile)){$tagfunc='tag_block_'.$tag_sel; $encode_tag_key=md5($tag); $param=$this->get_params($tag, 0); $as=isset($param['as'])?$param['as']:'vo'; $askey=isset($param['key'])?$param['key']:'k'; if(!$GLOBALS['linktag_display'] && $param['type']=='link' && config('cms_type')!='wanzhan'){$GLOBALS['inlinktag']=true; } if(!$GLOBALS['inlinktag']){$sp='array('; foreach($param as $k=>$vo){$s='\''.$k.'\'=>'.'\''.addslashes($vo).'\','; if($vo{0}=='$'){$s='\''.$k.'\'=>'.$vo.','; } $sp.=$s; } $sp.=')'; return '<?php if(!isset($this->_tags_data)){ $this->_tags_data=array(); } if($this->_tags_data["'.$encode_tag_key.'"]=$this->'.$tagfunc.'('.$sp.')){ foreach($this->_tags_data["'.$encode_tag_key.'"] as $this->_var["'.$askey.'"]=>$this->_var["'.$as.'"]){ ?>'; } } return $this->left_delimiter.$tag.$this->right_delimiter; break; } } return $this->left_delimiter.$tag.$this->right_delimiter; } public function get_val($val){if(strrpos($val, '[') !== false){$val=preg_replace_callback("/\[([^\[\]]*)\]/is",'temp_func_362', $val); } if(strrpos($val, '|') !== false){$moddb=explode('|', $val); $val=array_shift($moddb); } if(empty($val)){return ''; } if(strpos($val, '.$') !== false){$all=explode('.$', $val); foreach($all as $key=>$val){$all[$key]=$key == 0 ? $this->make_var($val) : '[' . $this->make_var($val) . ']'; } $p=implode('', $all); } else{$p=$this->make_var($val); } if(!empty($moddb)){foreach($moddb as $key=>$mod){$s=explode(':', $mod,2); switch($s[0]){case 'default': if($s[1]{0}== '$'){$v=$this->get_val(substr($s[1],1)); }else if(preg_match('~^"[^\$]+\$[a-z,A-Z][\w]+\W*[^\"]*"$~',$s[1])){preg_match_all('~(\$[a-z,A-Z][\w]+)~',$s[1],$match); array_shift($match); $match=array_shift($match); usort($match,'temp_func_399'); foreach($match as $k=>$vo){$s[1]=str_replace($vo,'{'.$this->get_val(substr($vo,1)).'}',$s[1]); } $v=$s[1]; }else{$v=$s[1]; } $p='(!isset('.$p.') || '.$p.'===\'\') ? ' . $v . ' : ' . $p; break; default: if(function_exists($s[0])){if($s[0]=='date' && strpos($s[1],'###')===false){$s[1].=',###'; } if(strpos($s[1],'###')!==false){$s[1]=str_replace('###',$p,$s[1]); } $args=explode(',',$s[1]); if($s[1]==''){$args=array($p); } $p=$s[0].'('.implode(',',$args).')'; } break; } } } return $p; } public function make_var($val){$systemVars=array('GLOBALS','_SERVER','_GET','_POST','_FILES','_COOKIE','_SESSION','_REQUEST','_ENV'); if(strrpos($val, '.') === false){if(isset($this->_var[$val]) && isset($this->_patchstack[$val])){$val=$this->_patchstack[$val]; } $val=trim($val,'"'); $val=trim($val,'\''); $p=in_array($val,$systemVars)?'$'. $val:'$this->_var[\'' . $val . '\']'; preg_match('~^[a-zA-Z_\x7f-\xff][\w\x7f-\xff]*~',$val,$match); $temp=str_replace($match[0],'',$val); if($temp){$p=in_array($val,$systemVars)?'($'.$match[0].$temp.')':'($this->_var[\'' . $match[0] . '\']'.$temp.')'; } } else{$t=explode('.', $val); $_var_name=array_shift($t); if(isset($this->_var[$_var_name]) && isset($this->_patchstack[$_var_name])){$_var_name=$this->_patchstack[$_var_name]; } $_var_name=trim($_var_name,'"'); $_var_name=trim($_var_name,'\''); $p=in_array($_var_name,$systemVars)?'$'. $_var_name:'$this->_var[\'' . $_var_name . '\']'; foreach($t as $val){$val=trim($val,'"'); $val=trim($val,'\''); $p.='[\'' . $val . '\']'; } } return $p; } public function &getTemplateVars($name=null){if(empty($name)){return $this->_var; } elseif(!empty($this->_var[$name])){return $this->_var[$name]; } else{$_tmp=null; return $_tmp; } } public function get_params($tag, $type=1){$tag=preg_replace('~([\w]+)\s*=\s*([\w\'"]+)~',' $1=$2',$tag); $tagArr=preg_split('~([\w]+=)~',$tag,0,PREG_SPLIT_DELIM_CAPTURE); array_shift($tagArr); $icount=count($tagArr); $newtagarr=array(); for($i=0;$i<$icount;$i++){if(preg_match('~^(\w+)=$~',$tagArr[$i])){$newtagarr[]=trim($tagArr[$i]).trim($tagArr[$i+1]); $i++; } } foreach ($newtagarr as $value){if (strrpos($value, '=')){list($a, $b)=explode('=', str_replace(array('"', "'", '&quot;'), '', $value)); if ($b{0} == '$'){if ($type){eval('$para[\'' . $a . '\']=' . $this->get_val(substr($b, 1)) . ';'); }else{$para[$a]=$this->get_val(substr($b, 1)); } }else{$para[$a]=$b; } } } return $para; } public function _compile_if_tag($tag_args, $elseif=false){preg_match_all('/\-?\d+[\.\d]+|\'[^\'|\s]*\'|"[^"|\s]*"|[\$\w\.]+|!==|===|==|!=|<>|<<|>>|<=|>=|&&|\|\||\(|\)|,|\!|\^|=|&|<|>|~|\||\%|\+|\-|\/|\*|\@|\S/', $tag_args, $match); $tokens=$match[0]; $token_count=array_count_values($tokens); if(!empty($token_count['(']) && $token_count['('] != $token_count[')']){$this->_syntax_error('unbalanced parenthesis in if statement', E_USER_ERROR, __FILE__, __LINE__); } for($i=0, $count=count($tokens); $i < $count; $i++){$token=&$tokens[$i]; switch(strtolower($token)){case 'and': $token='&&'; break; case 'or': $token='||'; break; default: if($token[0] == '$'){$token=$this->get_val(substr($token, 1)); } break; } } if($count == 6 && $tokens[2][0] != '$'){} $str=$count == 6 ?($tokens[0] . $tokens[1] . $tokens[2] . $tokens[3] . ' ' . $tokens[4] . ' ' . $tokens[5]) : implode(' ', $tokens); if($elseif){return '<?php elseif(' . $str . '): ?>'; } else{return '<?php if(' . $str . '): ?>'; } } public function _compile_foreach_start($tag_args){if(stripos($tag_args,' as ')!==false){$tag_args=trim($tag_args); $tag_args=str_ireplace(' as ',' as ',$tag_args); $arr=explode(' as ',$tag_args); $attrs=$this->get_params('from='.$arr[0],0); if(strpos($arr[1],'=>')!==false){list($k,$vo)=explode('=>',$arr[1]); $attrs['item']=substr(trim($vo),1); $attrs['key']=substr(trim($k),1); }else{$attrs['item']=substr(trim($arr[1]),1); } }else{$attrs=$this->get_params($tag_args, 0); } $arg_list=array(); $from=$attrs['from']; if(isset($this->_var[$attrs['item']]) && !isset($this->_patchstack[$attrs['item']]) and 1==2){$this->_patchstack[$attrs['item']]=$attrs['item'] . '_' . str_replace(array(' ', '.'), '_', microtime()); $attrs['item']=$this->_patchstack[$attrs['item']]; } else{$this->_patchstack[$attrs['item']]=$attrs['item']; } $item=$this->get_val($attrs['item']); if(!empty($attrs['key'])){$key=$attrs['key']; $key_part=$this->get_val($key) . ' => '; } else{$key=null; $key_part=''; } if(!empty($attrs['name'])){$name=$attrs['name']; } else{$name=null; } $output='<?php '; $output.="\$_from=$from; if(!is_array(\$_from) && !is_object(\$_from)){ settype(\$_from, 'array'); }; \$this->push_vars('$attrs[key]', '$attrs[item]');"; if(!empty($name)){$foreach_props="\$this->_foreach['$name']"; $output.="{$foreach_props}=array('total' => count(\$_from), 'iteration' => 0);\n"; $output.="if({$foreach_props}['total'] > 0):\n"; $output.="    foreach(\$_from AS $key_part$item):\n"; $output.="        {$foreach_props}['iteration']++;\n"; } else{$output.="if(count(\$_from)):\n"; $output.="    foreach(\$_from AS $key_part$item):\n"; } return $output . '?>'; } public function push_vars($key, $val){if(!empty($key)){array_push($this->_temp_key, "\$this->_vars['$key']='" . $this->_vars[$key] . "';"); } if(!empty($val)){array_push($this->_temp_val, "\$this->_vars['$val']='" . $this->_vars[$val] . "';"); } } public function display($filename, $cache_id=''){$out=$this->fetch($filename, $cache_id); echo $out; } public function pop_vars(){$key=array_pop($this->_temp_key); $val=array_pop($this->_temp_val); if(!empty($key)){eval($key); } } function prefilter_preCompile($source){$file_type=strtolower(strrchr($this->_current_file, '.')); $pattern=array('/<!--[^>|\n]*?({.+?})[^<|{|\n]*?-->/', '/<!--[^\n]*?-->/', ); $replace=array('\1', '', ); return preg_replace($pattern, $replace, $source); } public function parse_params($str){while(strpos($str, '= ') != 0){$str=str_replace('= ', '=', $str); } while(strpos($str, ' =') != 0){$str=str_replace(' =', '=', $str); } return explode(' ', trim($str)); } public function template_error($msg){if(APP_DEBUG || config('web_debug')){ob_end_clean(); exit('<meta content="charset=utf-8">'.$msg); } } public function _eval($content){ob_start(); try{eval('?' . '>' . trim($content)); }catch(Error $e){$this->template_exception($e); } $content=ob_get_contents(); ob_end_clean(); return $content; } public function template_exception($e){$error=array(); $error['message']=$e->getMessage(); $trace=$e->getTrace(); $error['line']=$e->getLine(); if(isset($trace[0]['args'][0])){$str=$trace[0]['args'][0]; $arr=explode("\n",$str); $c=count($arr); $seeline=30; $startline=intval($error['line']-$seeline/2); if($startline<0){$startline=0; } $arr=array_slice($arr,$startline,$seeline,true); $errcode=''; foreach($arr as $k=>$vo){$vo=trim(htmlspecialchars($vo)); $linenum=$k; if($k==($error['line']-1)){$errcode.='<p style="background:#ffd5d5;color:red;font-weight:bold;"><span>'.$linenum.'</span>'.$vo.'</p>'; }else{$errcode.='<p><span>'.$linenum.'</span>'.$vo.'</p>'; } } $errmsg='<style type="text/css">p{margin:0;}span{padding:0 5px;background:#ddd;width:40px;display: inline-block;color:#555;text-align:right;}</style><br/>模板渲染发生错误，报错信息：<font color="red">'.$error['message'].'</font><br/><br/>发生错误的代码：<hr/><div>'.$errcode.'</div>'; $this->template_error($errmsg); } } public function _require($filename){debug_log('start_require'.$filename); debug_log('start_require'.$filename,'end'); debug_log('_require'.$filename); ob_start(); include $filename; $content=ob_get_contents(); ob_end_clean(); debug_log('_require'.$filename,'end'); return $content; } public function make_array($arr){$out=''; foreach($arr AS $key=>$val){if($val{0} == '$'){$out.=$out ? ",'$key'=>$val" : "array('$key'=>$val"; } else{$out.=$out ? ",'$key'=>'$val'" : "array('$key'=>'$val'"; } } return $out . ')'; } function get_math_para($val){$pa=$this->parse_params($val); foreach($pa AS $value){if(strrpos($value, '=')){list($a, $b)=explode('=', str_replace(array(' ', '"', "'", '"'), '', $value)); if(strpos($b, '$') >= 0){$pattern="/\\$[_a-zA-z]+[a-zA-Z0-9_]*/"; preg_match($pattern, $b, $arr); if($arr){foreach($arr as $match){$v=$this->get_val(substr($match, 1)); $b=str_replace($match, $v, $b); } } } } } return $b; } private function write($file,$data,$method="w"){$dir=dirname($file); if(!is_dir($dir)){mkdir($dir,0777,true); } if( is_file($file) && !is_writable($file)){return false; } $result=false; if($fp=fopen($file,$method)){$startTime=microtime(); do{$canWrite=flock($fp,LOCK_EX | LOCK_NB); if(!$canWrite){usleep(round(rand(0,100)*1000)); } }while((!$canWrite)&&((microtime()-$startTime)<1000)); if($canWrite){$result=fwrite($fp,$data); } fclose($fp); } return $result; } public function __call($method,$args){global $���G;static $include=array(); $fmethod=preg_replace('~^tag_~','',$method); $fmethod=str_replace('_','.',$fmethod); $plugfile=$this->plugins_dir.$fmethod.'.php'; if(is_file($plugfile)){$key=md5($plugfile); if(!isset($include[$key])){$include[$key]=true; include_once($plugfile); } $method22=preg_replace('~^tag_([a-z]+)_([a-z]+)~','$2',$method); $gtagname='tag_'.$method22.'_runtime'; if(!isset($GLOBALS[$gtagname])){$GLOBALS[$gtagname]=0; } _runtime($gtagname); $a=$method($args); $GLOBALS[$gtagname]+=_runtime($gtagname,"end"); return $a; } } } ?>