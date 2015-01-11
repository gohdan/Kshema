<?php

// Base functions of the "uploads" module


include_once ($mods_dir."/files/index.php"); // to upload files
include_once ("db.php");

function uploads_admin()
{
	debug ("*** fn: uploads_admin ***");

    global $user;
    global $debug;

    global $upl_pics_dir;
    global $doc_root;
    global $max_file_size;
    global $home;
    $content = array(
		'content' => '',
		'type_upload' => '',
		'type_news' => '',
		'type_articles' => '',
		'type_banners' => ''
	);

	if (isset($_FILES['image'])) $image = $_FILES['image'];
    $if_file_exists = 0;
    $file_path = "";

	if (isset($_POST['type'])) $upload_type = $_POST['type'];
	else $upload_type = "uploads";

	$content['type_'.$upload_type] = "yes";

	debug ("user id: ".$user['id']);

	if (1 == $user['id'])
    {
        debug ("user is admin");

                if ("" != $image['name'])
                {
                    debug ("there is a file to upload");
                    if (file_exists($doc_root.$upl_pics_dir.$upload_type."/".$image['name'])) $if_file_exists = 1;
                    $file_path = upload_file($image['name'],$image['tmp_name'],$home,$upl_pics_dir.$upload_type."/",$if_file_exists);
                    debug ("size: ".filesize($home.$file_path));

                    if (filesize($home.$file_path) > $max_file_size)
                    {
                        debug ("file size > max file size!");
                        $content .= "<p>Простите, но нельзя закачать файл размером больше ".($max_file_size / 1024)." килобайт</p>";
                        if (unlink ($home.$file_path)) debug ("file deleted");
                        else debug ("can't delete file!");
                        $file_path = "";
                    }

                    $_POST['image'] = $file_path;

					$content['content'] .= "<p>Путь к файлу: <b>".$file_path."</b></p>";

                }
                else
                {
                    debug ("no file to upload");
                    $file_path = $_POST['image'];
                }


	}
    else
    {
        debug ("user isn't admin");
        $content['content'] = "<p>Пожалуйста, войдите в систему как администратор.</p>";
    }

	debug ("*** end: fn: uploads_admin ***");
    return $content;
}

function uploads_frontpage()
{
        global $user;
        global $debug;
        $content['content'] = "";

        debug ("*** uploads_frontpage ***");
        debug ("*** end: uploads_frontpage");

        return $content;
}

function uploads_help()
{
        global $user;
        global $config;
		debug ("*** uploads_help ***");
        $content['content'] = "";
        debug ("*** end: uploads_help");
        return $content;
}


function uploads_default_action()
{
        global $user;
        $content = "";
        $nav_string = "
        ";

        $content .= $nav_string;

        debug("<br>=== mod: uploads ===");

        if (isset($_GET['action']))
        {
                debug ("*** action: ".$_GET['action']);
                switch ($_GET['action'])
                {
                        default:
                                $content .= gen_content("uploads", "frontpage", uploads_frontpage());
                        break;

                        case "admin":
                                $content .= gen_content("uploads", "admin", uploads_admin());
                        break;

                        case "help":
                                $content .= gen_content("uploads", "help", uploads_help());
                        break;


                        case "create_tables":
                                $content .= gen_content("uploads", "tables_create", uploads_tables_create());
                        break;

                        case "drop_tables":
                                $content .= gen_content("uploads", "drop_tables", uploads_tables_drop());
                        break;

                        case "update_tables":
                                $content .= gen_content("uploads", "tables_update", uploads_tables_update());
                        break;						

                }
        }

        else
        {
                debug ("*** action: default");
                $content = gen_content("uploads_frontpage", uploads_frontpage());
        }

        debug("=== end: mod: uploads ===<br>");
        return $content;

}

?>
