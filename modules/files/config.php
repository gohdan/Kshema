<?php

$config['files']['upl_dir'] = "uploads/"; // must be writable to web server
$config['files']['files_dir'] = $config['base']['doc_root']."/".$config['files']['upl_dir']."files/";
$config['files']['max_size'] = 3000 * 1024; // in bytes
$config['files']['home'] = $config['base']['doc_root'];
$config['files']['elements_on_page'] = "20";
$config['files']['thumb_width'] = "200";
$config['files']['thumb_height'] = "100";

?>
