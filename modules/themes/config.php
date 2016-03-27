<?php

$config['themes']['current'] = "default";
$config['themes']['dir'] = $config['base']['doc_root']."/themes/";
$config['themes']['page_tpl'] = "default"; // could be changed by modules to show diffrnt
$config['themes']['menu_tpl'] = "";
$config['themes']['page_title'] = array(
	'site' => $config['base']['site_name'],
	'module' => '',
	'action' => '',
	'category' => '',
	'element' => '',
	'categories_title' => array()
);
$config['themes']['categories_title_reverse'] = "yes";
$config['themes']['admin'] = "no"; // common case 
$config['themes']['admin_page'] = "admin"; // admin - to use own page to admin interface, default - to use common page view
$config['themes']['page_404'] = "404";
$config['themes']['meta_keywords'] = "";
$config['themes']['meta_description'] = "";

$template['title'] = $config['base']['site_name'];

?>
