<?php
 class addon extends xxfseo_IllIlIIIlIIIIllIllllllIIlllIIlII{public $info=array(); public $config=array(); public $addon_path=''; public $config_file=''; public function __construct(){$this->addon_path=ADDONS_PATH.$this->getName(); if(is_file($this->addon_path.'/config.php')){$this->config_file=$this->addon_path.'/config.php'; $this->config=require($this->config_file); } $this->tplConf('template_dir',$this->addon_path.'/template'); $this->tplConf('compile_dir',TPLCACHE_PATH.'addon/'.$this->getName()); $this->tplConf('caching',false); $this->view()->template->compile_check=true; } final function fetch($templateFile=''){return $this->view()->fetch($templateFile); } final protected function display($template=''){return $this->view()->display($template); } final protected function assign($name,$value=''){$this->view()->assign($name,$value); return $this; } final public function getName(){$class=get_class($this); return substr($class,0,-5); } } 