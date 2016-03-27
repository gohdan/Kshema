<?php

$config['modules']['default_module'] = "frontpage";
$config['modules']['location'] = $config['base']['doc_root']."/modules/";

$config['modules']['current_module'] = "";
$config['modules']['current_id'] = "";
$config['modules']['current_category'] = "";
$config['modules']['current_title'] = "";

$config['modules']['core'][] = "auth";
$config['modules']['core'][] = "base";
$config['modules']['core'][] = "db";
$config['modules']['core'][] = "files";
$config['modules']['core'][] = "frontpage";
$config['modules']['core'][] = "hooks";
$config['modules']['core'][] = "menu";
$config['modules']['core'][] = "modules";
$config['modules']['core'][] = "templater";
$config['modules']['core'][] = "themes";
$config['modules']['core'][] = "updater";
$config['modules']['core'][] = "uploads";
$config['modules']['core'][] = "users";

$config['modules']['installed'][] = array();

?>
