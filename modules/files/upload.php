<?php

// Upload functions of the "files" modules

function upload_file ($file_name,$tmp_file_name,$home,$store_place,$if_file_exists)
{
	global $config;
	debug ("*** fn: upload_file ***");
    debug ("file name: ".$file_name);
	debug ("temp file_name: ".$tmp_file_name);
	debug ("home: ".$home);
	debug ("store place: ".$store_place);
	debug ("if file exists: ".$if_file_exists);
	debug ("script path: ".$_SERVER['SCRIPT_NAME']);
	debug ("domain dir: ".$config['base']['domain_dir']);


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
	while (file_exists($home.$config['base']['domain_dir'].$store_place.$file_name))
	{
		debug("file ".$file_name." exists, incrementing base name");
		$inc++;
		$fname[0] = $basename."_".$inc;
		$file_name = implode(".", $fname);
		debug("new name: ".$file_name);
	}

   	debug ("file doesn't exist, copying");
	$file_path = $store_place.$file_name;
	debug ("copying from: ".$tmp_file_name);
	debug ("copying to: ".$home.$config['base']['domain_dir'].$file_path);
   	copy ($tmp_file_name, $home.$config['base']['domain_dir'].$file_path);

	debug ("*** end: fn: upload_file");
    return ($file_path);
}



function files_upload($name, $dir)
{
	debug ("*** files_upload ***");
	global $config;
    global $user;

    global $upl_pics_dir;
    global $doc_root;
    global $max_file_size;
    global $home;

    debug ("name: ".$name);
    debug ("dir: ".$dir);

    if (isset($_FILES[$name])) $image = $_FILES[$name];
    $if_file_exists = 0;
    $file_path = "";


	if ((isset($image)) && ("" != $image['name']))
	{
		debug ("there is a file to upload");
		if (file_exists($dir."/".$image['name']))
		{
			debug ("file exists");
			$if_file_exists = 1;
		}
		else
			debug ("file doesn't exist");

		$domain_dir = $config['base']['domain_dir'];
		$config['base']['domain_dir'] = "";

		$file_path = upload_file($image['name'],$image['tmp_name'],"",$dir."/",$if_file_exists);

		$config['base']['domain_dir'] = $domain_dir;
		unset($domain_dir);

		debug ("size: ".filesize($file_path));

		if (filesize($file_path) > $max_file_size)
		{
			debug ("file size > max file size!");
			$content .= "<p>Простите, но нельзя закачать файл размером больше ".($max_file_size / 1024)." килобайт</p>";
			if (unlink ($home.$file_path)) debug ("file deleted");
			else debug ("can't delete file!");
			$file_path = "";
		}

		$_POST[$name] = $file_path;

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
	debug ("*** end: files_upload ***");
    return $file_path;
}

?>
