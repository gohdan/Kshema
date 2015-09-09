<?php

class File
{

function dir_create($name, $path)
{

	global $config;
	debug("*** File: dir_create ***");

	$result = mkdir ($path.$name);

	debug("*** end: File: dir_create ***");
	return ($result);
}

function dir_del($name, $path)
{

	global $config;
	debug("*** File: dir_del ***");

	$result = rmdir ($path.$name);

	debug("*** end: File: dir_del ***");
	return ($result);
}

function dir_edit($old_name, $name, $path)
{

	global $config;
	debug("*** File: dir_edit ***");

	$result = rename ($path.$old_name, $path.$name);

	debug("*** end: File: dir_edit ***");
	return ($result);
}

function del($name, $path)
{

	global $config;
	debug("*** File: del ***");

	$result = unlink($path.$name);

	debug("*** end: File: del ***");
	return ($result);
}

function path_determine($root, $categories_table, $parent)
{
	global $config;
	debug("*** File: path_determine ***");

	debug("root: ".$root);

	$path = $root;

	$cat = new Category();

	$parents = $cat -> get_parents_list($categories_table, $parent);
	$parents[] = $parent;

	debug("dir parents:", 2);
	dump($parents);

	foreach($parents as $k => $v)
		if($v)
			$path .= $cat -> get_name($categories_table, $v)."/";
	
	debug("path: ".$path);

	debug("*** end: File: path_determine ***");
	return ($path);
}

function upload($name, $dir = 0)
{
	debug ("*** fn: upload ***");
	global $config;
    global $user;

    global $upl_pics_dir;
    global $doc_root;
    global $max_file_size;
    global $home;

    debug ("name: ".$name);

	if (!$dir)
	{
		$module = $config['modules']['current_module'];
		if (isset($config[$module]['upl_dir']))
			$dir = $doc_root.$upl_pics_dir.$config[$module]['upl_dir'];
		else
			$dir = $doc_root.$upl_pics_dir.$module;
	}
    debug ("dir: ".$dir);

    if (isset($_FILES[$name]))
		$image = $_FILES[$name];
    $if_file_exists = 0;
    $file_path = "";

	if ((isset($image)) && ("" != $image['name']))
	{
		debug ("there is a file to upload");
		debug ("file name: ".$image['name']);
		debug ("file tmp name: ".$image['tmp_name']);
		if ("1" == $image['error'])
			debug("there was an error while uploading file to temp, maybe you have to check max_upload_filesize in php.ini");
		$path_check = $dir."/".$image['name'];
		debug ("checking file existence in the path: ".$path_check);
		if (file_exists($path_check))
		{
			debug ("file exists");
			$if_file_exists = 1;
		}
		else
			debug ("file doesn't exist");

		$domain_dir = $config['base']['domain_dir'];
		$config['base']['domain_dir'] = "";

		$file_path = $this -> stow($image['name'],$image['tmp_name'],"",$dir."/",$if_file_exists);

		$config['base']['domain_dir'] = $domain_dir;
		unset($domain_dir);

		debug ("size: ".filesize($file_path));

		if (filesize($file_path) > $max_file_size)
		{
			debug ("file size > max file size!");
			$content .= "<p>Простите, но нельзя закачать файл размером больше ".($max_file_size / 1024)." килобайт</p>";
			if (unlink ($file_path)) debug ("file deleted");
			else debug ("can't delete file!");
			$file_path = "";
		}

		//$_POST[$name] = $file_path;

	}
	else
	{
		debug ("no file to upload");
		if (isset($_POST["old_".$name]))
			$file_path = $_POST["old_".$name];
		else
			$file_path = "";
	}

	debug ("File path on FS: ".$file_path);
	debug ("doc_root: ".$doc_root);
	debug ("domain_dir: ".$config['base']['domain_dir']);
	$file_path = str_replace ($doc_root.$config['base']['domain_dir'], "", $file_path);
	debug ("file path in DB: ".$file_path);
	debug ("*** end: fn: upload ***");

    return $file_path;
}

function stow ($file_name,$tmp_file_name,$home,$store_place,$if_file_exists)
{
	global $config;
	debug ("*** fn: stow ***");
    debug ("file name: ".$file_name);
	debug ("temp file_name: ".$tmp_file_name);
	debug ("home: ".$home);
	debug ("store place: ".$store_place);
	debug ("if file exists: ".$if_file_exists);
	debug ("script path: ".$_SERVER['SCRIPT_NAME']);
	debug ("domain dir: ".$config['base']['domain_dir']);

	$file_name = $this -> gen_unique_name($home.$config['base']['domain_dir'].$store_place, $file_name);

   	debug ("file doesn't exist, copying");
	$file_path = $store_place.$file_name;
	debug ("copying from: ".$tmp_file_name);
	debug ("copying to: ".$home.$config['base']['domain_dir'].$file_path);
   	copy ($tmp_file_name, $home.$config['base']['domain_dir'].$file_path);

	debug ("*** end: fn: stow");
    return ($file_path);
}

function get_size($file, $if_human = 0)
{
	global $config;
	debug("*** fn: get_size ***");

	$size = filesize($config['base']['doc_root'].$file);
	if ($if_human)
		$size = format_bytes($size);

	debug("*** end: fn: get_size ***");
	return ($size);
}

function get_thumbnail($file)
{
	global $config;
	debug("*** fn: get_thumbnail ***");

	
	$ftype = mime_content_type($config['base']['doc_root'].$file);
	debug("file type: ".$ftype, 2);

	$thumb = "";
	$width = $config['files']['thumb_width'];
	$height = $config['files']['thumb_height'];

	if ("image" == substr($ftype, 0, 5))
		$thumb = "/libs/phpthumb/phpThumb.php?src=".$file."&w=".$width."&h=".$height;

	else if ("application/pdf" == substr($ftype, 0, 15))
		$thumb = "/themes/".$config['themes']['current']."/images/filetypes/pdf.jpg";

	else 
		$thumb = "/themes/".$config['themes']['current']."/images/filetypes/unknown.jpg";


	debug("*** end: fn: get_thumbnail ***");
	return $thumb;
}

function gen_unique_name($path, $file_name)
{
	global $config;
	debug ("*** fn: gen_unique_name ***");

	$fname_parts = explode(".", $file_name);
	$fname_parts_qty = count($fname_parts);
	$file_name = "";
	for ($i = 0; $i < ($fname_parts_qty - 1); $i++)
		$file_name .= $fname_parts[$i];

	$file_name = transliterate($file_name, "ru", "en").".".transliterate($fname_parts[$i++], "ru", "en");
	debug ("transliterated file name: ".$file_name);

	$fname = explode(".", $file_name);
	$basename = $fname[0];

	$inc = 1;
	while (file_exists($path.$file_name))
	{
		debug("file ".$file_name." exists, incrementing base name");
		$inc++;
		$fname[0] = $basename."_".$inc;
		$file_name = implode(".", $fname);
		debug("new name: ".$file_name);
	}

	debug ("*** end: fn: gen_unique_name ***");
	return $file_name;
}

function download($url)
{
	global $config;

	debug("*** fn: url ***");
	debug("url: ".$url);

	$file_path = "";

	if ("" != $url)
	{
		debug("url is not empty, downloading");
		$module = $config['modules']['current_module'];
		$dir = $config['base']['doc_root'].$config['files']['upl_dir'].$config[$module]['upl_dir'];
		debug("dir: ".$dir);

		$url_arr = explode("/", $url);
		$fname = array_pop($url_arr);
		debug("fname: ".$fname);

		$fname = $this -> gen_unique_name($dir, $fname);

		$file_path =  $dir.$fname;

		file_put_contents($file_path, file_get_contents($url));
	}
	else
		debug("url is empty, doing nothing");

	debug("*** end: fn: url ***");
	return $file_path;
}


}

?>
