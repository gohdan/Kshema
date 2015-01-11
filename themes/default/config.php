<?php
// +----------------------------------------------------------------------
// | PHP Source
// +----------------------------------------------------------------------
// | Copyright (C) 2006 by Goh'Dan <gohdan@mail.ru>
// +----------------------------------------------------------------------
// |
// | Copyright: See COPYING file that comes with this distribution
// +----------------------------------------------------------------------
//

global $config;
global $debug;
global $user;
global $theme_dir;
global $upl_pics_dir;
global $doc_root;
global $max_file_size;
global $home;
global $page_title;
global $template;

include_once ("db_config.php"); // change to site-specific of default

$mods_dir = "modules";
$theme_dir = $_SERVER['DOCUMENT_ROOT']."/themes/default"; // change to site-specific or default

$upl_pics_dir = "/uploads/"; // must be writable to web server
$max_file_size = 2000 * 1024; // in bytes
$doc_root = $_SERVER['DOCUMENT_ROOT'];
$home = $doc_root;

$page_title = "Kshema";
$default_module = "frontpage";


$config['base']['version'] = "0.8.5";

$config['base']['debug_level'] = 0; // 0 - no debug, 1 - simple debug, 2 - verbose debug (var dump etc.);
$config['base']['debug_user'] = 0; // set to 0 to show debug to every (even non-authenticated) user
$config['base']['error_reporting'] = 0; // use in production
//$config['base']['error_reporting'] = E_ALL; // use to develop
$config['base']['logs_path'] = $_SERVER['DOCUMENT_ROOT']."/logs/";
$config['base']['logs_write'] = "no";
$config['base']['debug_echo'] = "yes";
$config['base']['debug_file'] = "no";

$config['base']['site_name'] = "Kshema";
$config['base']['site_owner'] = "Goh'Dan";
$config['base']['site_url'] = "http://kshema-test.gohdan.ru";
$config['base']['admin_email'] = "gohdan@gohdan.ru";
$config['base']['inst_root'] = ""; // Put here a directory Kshema is installed in; no slash at the end!
$config['base']['domain_dir'] = "";
$config['base']['doc_root'] = $_SERVER['DOCUMENT_ROOT'].$config['base']['inst_root'] ;
$config['base']['output_charset'] = "utf8"; // utf8 or utf8

$config['base']['ftp_server'] = "kshema.handyhosting.ru";
$config['base']['ftp_username'] = "kshema";
$config['base']['ftp_password'] = "kshems";
$config['base']['ftp_root'] = '/home/kshema/www/';

$config['base']['categories']['list_prefix'] = " .";
$config['base']['categories']['chain_divider'] = " / ";

$config['base']['ext_links_redirect'] = "yes";
$config['base']['use_captcha'] = "no";

$config['base']['lang']['default'] = "ru";
$config['base']['lang']['current'] = $config['base']['lang']['default'];
$config['base']['lang']['list'][] = "ru";
$config['base']['lang']['list'][] = "en";
$config['base']['lang']['list'][] = "de";

$config['base']['send_emails'] = "yes"; // set to "yes" to send

$config['base']['mail']['from_address'] = "kshema@handyhosting.ru";
$config['base']['mail']['from_name'] = "Kshema";
$config['base']['mail']['host'] = "handyhosting.ru"; // Host to connect. Default is localhost
$config['base']['mail']['username'] = "kshema"; // The username to use for SMTP authentication.
$config['base']['mail']['password'] = "kshema"; // The password to use for SMTP authentication.
$config['base']['mail']['port'] = "25"; // The port to connect. Default is 25
$config['base']['mail']['backend'] = "smtp"; // mail, sendmail, smtp
$config['base']['mail']['sendmail_path'] = "/usr/bin/sendmail"; // The location of the sendmail program on the filesystem. Default is /usr/bin/sendmail
$config['base']['mail']['sendmail_args'] = "-i"; // Additional parameters to pass to the sendmail. Default is -i
$config['base']['mail']['auth'] = "TRUE"; // Whether or not to use SMTP authentication. Default is FALSE
$config['base']['mail']['localhost'] = "localhost"; // The value to give when sending EHLO or HELO. Default is localhost
$config['base']['mail']['timeout'] = "NULL"; // The SMTP connection timeout. Default is NULL (no timeout)
$config['base']['mail']['verp'] = "FALSE"; // Whether to use VERP or not. Default is FALSE
$config['base']['mail']['debug'] = "TRUE"; // Whether to enable SMTP debug mode or not. Default is FALSE
//$config['base']['mail']['persist'] = "yes"; // Indicates whether or not the SMTP connection should persist over multiple calls to the send() method.
$config['base']['mail']['use_phpmailer'] = "yes"; // Use PHPMailer class to send emails through SMTP

$config['base']['timezone'] = "Europe/Moscow";

$config['libs']['location'] = $_SERVER['DOCUMENT_ROOT']."libs/";

$config['articles']['default_action'] = "view_by_category";
//$config['articles']['default_action'] = "view_by_user";
$config['articles']['elements_on_page'] = 20;
$config['articles']['xmlrpc_use'] = "1";
$config['articles']['resemble_elements_qty'] = "5";
$config['articles']['table'] = "ksh_articles";
$config['articles']['categories_table'] = "ksh_articles_categories";

$config['auth']['allow_registration'] = "no";

$config['auto_models']['sort_list_by'] = "name";
$config['auto_models']['elements_on_page'] = 100;
$config['auto_models']['present_cols'] = 2;

$config['bbcpanel']['bbcpanel_domain'] = "kshema.handyhosting.ru";
$config['bbcpanel']['bb_id'] = 33;
$config['bbcpanel']['password'] = "kshema";

$config['bills']['bills_on_page'] = "5";
$config['bills']['default_action'] = "view_by_category";
//$config['bills']['default_action'] = "view_by_user";
$config['bills']['resemble_bills_qty'] = 5;
$config['bills']['use_captcha'] = "yes";
$config['bills']['table'] = "ksh_bills";
$config['bills']['categories_table'] = "ksh_bills_categories";

$config['counter']['use'] = "no";

$config['db']['connected'] = "no";
$config['db']['timezone'] = "+04:00";

$config['files']['upl_dir'] = "uploads/"; // must be writable to web server
$config['files']['files_dir'] = $config['base']['doc_root']."/".$config['files']['upl_dir']."files/";
$config['files']['max_size'] = 3000 * 1024; // in bytes
$config['files']['home'] = $config['base']['doc_root'];
$config['files']['elements_on_page'] = "20";
$config['files']['thumb_width'] = "200";
$config['files']['thumb_height'] = "100";

$config['guestbook']['messages_on_page'] = "20";

$config['hooks']['default_action'] = "admin";
$config['hooks']['elements_on_page'] = "20";

$config['menu']['sort_list_by'] = "position";

$config['modules']['default_module'] = "pages";
$config['modules']['location'] = $config['base']['doc_root']."/modules/";
$config['modules']['current_module'] = "";
$config['modules']['current_id'] = "";
$config['modules']['current_category'] = "";
$config['modules']['current_title'] = "";

$config['modules']['core'][] = "hooks";
$config['modules']['core'][] = "menu";
$config['modules']['core'][] = "uploads";
$config['modules']['core'][] = "users";
$config['modules']['core'][] = "updater";

$config['modules']['installed'][] = "news";
$config['modules']['installed'][] = "pages";
$config['modules']['installed'][] = "articles";
$config['modules']['installed'][] = "bbcpanel";
$config['modules']['installed'][] = "bills";
$config['modules']['installed'][] = "themes";
$config['modules']['installed'][] = "guestbook";
$config['modules']['installed'][] = "files";
$config['modules']['installed'][] = "auto_models";

$config['pages']['page_title'] = "Kshema";
$config['pages']['sort_list_by'] = "name";

$config['news']['last_news_qty'] = 3;
$config['news']['news_template'] = "view";
$config['news']['rss_url'] = "";
$config['news']['category_template'] = "view_by_category";
$config['news']['newslist_template'] = "news";
$config['news']['page_tpl'] = "default";
$config['news']['menu_tpl'] = "news";
$config['news']['rss_qty'] = 10;

$config['performance']['use'] = "yes";

$config['projects']['another_doc_root'] = "/var/www/html/kshema/www/";

$config['redirect']['immediately'] = "yes";

$config['rss']['use'] = "yes";
$config['rss']['feeds'][] = "";
$config['rss']['max_items'] = 100;

$config['satellite']['use'] = "no";
$config['satellite']['table'] = "ksh_bbcpanel_bbs";
$config['satellite']['id'] = "1";

$config['shop']['lastitems'] = "4";
$config['shop']['goods_on_page'] = "20";
$config['shop']['categories_goods_sort_by'] = "name";
$config['shop']['show_last_goods_link'] = "yes";
$config['shop']['new_goods_sort_by'] = "name";
$config['shop']['popular_goods_sort_order'] = "name";
$config['shop']['recommended_goods_sort_by'] = "id";
$config['shop']['recommended_goods_sort_order'] = "DESC";

$config['templater']['show_null_values'] = "no"; // set to "yes" to show

$config['themes']['current'] = "default";
$config['themes']['dir'] = $config['base']['doc_root']."/themes/";
$config['themes']['page_tpl'] = "default"; // could be changed by modules to show diffrnt
$config['themes']['menu_tpl'] = "";
$template['title'] = $config['base']['site_name'];
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
$config['themes']['admin_page'] = "default"; // admin - to use own page to admin interface, default - to use common page view
$config['themes']['page_404'] = "404";

$config['updater']['url'] = "http://kshema.handyhosting.ru/updates/";
$config['updater']['dl_path'] = "uploads/updater/";
$config['updater']['file_all'] = "all.zip";
$config['updater']['rights_files'] = "664";
$config['updater']['rights_dirs'] = "774";

$config['users']['xmlrpc_use'] = "0";
$config['users']['table'] = "ksh_users";
$config['users']['categories_table'] = "ksh_users_groups";
$config['users']['additional_fields'][0]['name'] = "";
$config['users']['additional_fields'][0]['title'] = "";
$config['users']['additional_fields'][0]['db_type'] = "";

$config['weather']['link'] = "http://api.wunderground.com/api/***/geolookup/conditions/q/***.json";
$config['weather']['update_interval'] = 3600;

?>
