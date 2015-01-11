<?php

// News administration functions of the "photos" module

include_once ($mods_dir."/files/index.php"); // to upload pictures

function photos($category)
{
    debug("*** photos ***");
    global $user;
    $content = "";
    $photos = 3;

    debug ("category name: ".$category);
    $category_id = mysql_result(exec_query("SELECT id FROM ksh_photos_categories WHERE name='".mysql_real_escape_string($category)."'"), 0, 0);
    debug ("category id: ".$category_id);
    $result = exec_query("SELECT * FROM ksh_photos_galleries WHERE category='".mysql_real_escape_string($category_id)."' ORDER BY id DESC LIMIT ".mysql_real_escape_string($photos)."");

    $content .= "<table>";
    while ($row = mysql_fetch_array($result))
    {
        debug("show galleries ".$row['id']);
        $content .= "<tr>";
        //$content .= "<td><img src=\"".$row['image']."\"></td>";
        $content .= "<td>
                    <a href=\"/index.php?module=photos&action=view_gallery&gallery=".$row['id']."\">".$row['name']."</a>
                    </td>";
        $content .= "</tr>";

    }
    mysql_free_result($result);
    $content .= "</table>";

    if (1 == $user['id']) $content .= "<p><a href=\"/index.php?module=photos&action=admin\">Администрирование</a></p>";
    return $content;
    debug("*** end: photos ***");
}

function lastphotos($category)
{
    debug("*** lastphotos ***");
    global $user;
    $content = "";
    $photos = 3;

    debug ("category name: ".$category);
    $result = exec_query("SELECT * FROM ksh_photos_galleries ORDER BY id DESC LIMIT ".mysql_real_escape_string($photos)."");

    $content .= "<table>";
    while ($row = mysql_fetch_array($result))
    {
        debug("show galleries ".$row['id']);
        $content .= "<tr>";
        //$content .= "<td><img src=\"".$row['image']."\"></td>";
        $content .= "<td>
                    <a href=\"/index.php?module=photos&action=view_gallery&gallery=".$row['id']."\">".$row['name']."</a>
                    </td>";
        $content .= "</tr>";

    }
    mysql_free_result($result);
    $content .= "</table>";

    if (1 == $user['id']) $content .= "<p><a href=\"/index.php?module=photos&action=admin\">Администрирование</a></p>";
    return $content;
    debug("*** end: lastphotos ***");
}


function photos_last($category)
{
    debug("*** photos_last ***");
    global $user;
    $content = "";
    $photos = 3;

    debug ("category name: ".$category);
    $category_id = mysql_result(exec_query("SELECT id FROM ksh_photos_categories WHERE name='".mysql_real_escape_string($category)."'"), 0, 0);
    debug ("category id: ".$category_id);
    $result = exec_query("SELECT * FROM ksh_photos WHERE category='".mysql_real_escape_string($category_id)."' ORDER BY id DESC LIMIT ".mysql_real_escape_string($photos)."");

    $content .= "<table>";
    while ($row = mysql_fetch_array($result))
    {
        debug("show photos ".$row['id']);
        $content .= "<tr><td><img src=\"".$row['image']."\"></td><td>
                    <a href=\"\">".$row['date']."</a><br>
                    <a href=\"\">".$row['name']."</a><br>
                    ".stripslashes($row['descr'])."<br>
                    <span class=\"more\"><a href=\"\">Подробнее...</a></span>
                </td></tr>
        ";
    }
    mysql_free_result($result);
    $content .= "</table>";

    if (1 == $user['id']) $content .= "<p><a href=\"/index.php?module=photos&action=admin\">Администрирование</a></p>";
    return $content;
    debug("*** end: photos_last ***");
}

function photos_add()
{
    debug ("*** photos_add ***");
    global $user;
    global $config;

	$content = array(
		'content' => '',
		'result' => '',
		'gallery' => ''
	);

    global $upl_pics_dir;
    global $doc_root;
    global $max_file_size;
    global $home;

    if (isset($_FILES['image'])) $image = $_FILES['image'];
    $if_file_exists = 0;
    $file_path = "";

    if (isset($_FILES['thumb'])) $thumb = $_FILES['thumb'];
    $if_thumb_exists = 0;
    $thumb_path = "";
    
    debug ("user id: ".$user['id']);
    if (1 == $user['id'])
    {
        debug ("user is admin");

        $content['gallery'] = $_GET['gallery'];

        if (isset($_POST['do_add']))
        {
                if ("" != $image['name'])
                {
                    debug ("there is an image to upload");
                    if (file_exists($doc_root.$upl_pics_dir."photos/".$image['name'])) $if_file_exists = 1;
                    $file_path = upload_file($image['name'],$image['tmp_name'],$home,$upl_pics_dir."photos/",$if_file_exists);
                    debug ("size: ".filesize($home.$file_path));

                    if (filesize($home.$file_path) > $max_file_size)
                    {
                        debug ("file size > max file size!");
                        $content['result'] .= "Простите, но нельзя закачать файл размером больше ".($max_file_size / 1024)." килобайт";
                        if (unlink ($home.$file_path)) debug ("file deleted");
                        else debug ("can't delete file!");
                        $file_path = "";
                    }

                    $_POST['image'] = $file_path;

                }
                else
                {
                    debug ("no image to upload");
                    $file_path = $_POST['image'];
                }

                if ("" != $thumb['name'])
                {
                    debug ("there is a thumb to upload");
                    if (file_exists($doc_root.$upl_pics_dir."photos/".$thumb['name'])) $if_thumb_exists = 1;
                    $thumb_path = upload_file($thumb['name'],$thumb['tmp_name'],$home,$upl_pics_dir."photos/",$if_thumb_exists);
                    debug ("size: ".filesize($home.$thumb_path));

                    if (filesize($home.$thumb_path) > $max_file_size)
                    {
                        debug ("thumb size > max file size!");
                        $content['result'] .= "Простите, но нельзя закачать файл размером больше ".($max_file_size / 1024)." килобайт";
                        if (unlink ($home.$thumb_path)) debug ("thumb deleted");
                        else debug ("can't delete thumb!");
                        $thumb_path = "";
                    }

                    $_POST['thumb'] = $thumb_path;

                }
                else
                {
                    debug ("no thumb to upload");
                    $thumb_path = $_POST['thumb'];
                }


            debug ("have data to add");
            if ("" != $_POST['name'])
            {
                debug ("photos name isn't empty");
                exec_query("INSERT INTO ksh_photos (image, thumb, name, gallery, descr, date) VALUES ('".mysql_real_escape_string($file_path)."', '".mysql_real_escape_string($thumb_path)."', '".mysql_real_escape_string($_POST['name'])."','".mysql_real_escape_string($_POST['gallery'])."','".mysql_real_escape_string($_POST['descr'])."', CURDATE())");
                $content['result'] .= "Фотография добавлена";
            }
            else
            {
                debug ("photos name is empty");
                $content['result'] .= "Пожалуйста, задайте название фотографии";
            }
        }
        else
        {
            debug ("no data to add");
        }
    }
    else
    {
        debug ("user isn't admin");
        $content['result'] = "Пожалуйста, войдите в систему как администратор";
    }

    debug ("*** end: photos_add ***");
    return $content;
}

function photos_del()
{
    debug ("*** photos_del ***");
    global $user;
	global $config;
	$content = array(
		'content' => '',
		'result' => '',
		'id' => '',
		'name' => '',
		'gallery' => ''
	);
    
	if (1 == $user['id'])
    {
        debug ("user has admin rights");
        $result = exec_query("SELECT * FROM ksh_photos WHERE id='".mysql_real_escape_string($_GET['photo'])."'");
        $photo = mysql_fetch_array($result);
        mysql_free_result($result);

        $content['id'] = stripslashes($photo['id']);
        $content['name'] = stripslashes($photo['name']);
        $content['gallery'] = stripslashes($photo['gallery']);
    }
    else
    {
        debug ("user doesn't have admin rights!");
        $content['result'] .= "Пожалуйста, войдите в систему как администратор";
    }

    debug ("*** end: photos_del ***");
    return $content;
}

function photos_edit()
{
    debug ("*** photos_edit ***");
    global $user;
    global $config;

	$content = array(
		'content' => '',
		'result' => '',
		'gallery' => '',
		'gallery_id' => '',
		'name' => '',
		'descr' => '',
		'image' => '',
        'thumb' => ''
	);

    global $upl_pics_dir;
    global $doc_root;
    global $max_file_size;
    global $home;

    if (isset($_FILES['image']))
    {
        debug ("have an image!");
        $image = $_FILES['image'];
    }
    else debug ("don't have an image!");
    $if_file_exists = 0;
    $file_path = "";

    if (isset($_FILES['thumb']))
    {
        debug ("have a thumb!");
        $thumb = $_FILES['thumb'];
    }
    else debug ("don't have a thumb!");
    $if_thumb_exists = 0;
    $thumb_path = "";

    
    if (isset($_GET['photo'])) $photo_id =$_GET['photo'];
    else if (isset($_POST['id'])) $photo_id =$_POST['id'];
    else $photo_id =0;
    debug ("photos id: ".$photo_id);

    debug ("user id: ".$user['id']);
    if (1 == $user['id'])
    {
        debug ("user is admin");

        if (isset($_POST['do_update']))
        {
                if ("" != $image['name'])
                {
                    debug ("there is an image to upload");
                    if (file_exists($doc_root.$upl_pics_dir."photos/".$image['name'])) $if_file_exists = 1;
                    $file_path = upload_file($image['name'],$image['tmp_name'],$home,$upl_pics_dir."photos/",$if_file_exists);
                    debug ("size: ".filesize($home.$file_path));

                    if (filesize($home.$file_path) > $max_file_size)
                    {
                        debug ("file size > max file size!");
                        $content['result'] .= "Простите, но нельзя закачать файл размером больше ".($max_file_size / 1024)." килобайт";
                        if (unlink ($home.$file_path)) debug ("file deleted");
                        else debug ("can't delete file!");
                        $file_path = $_POST['old_image'];
                    }

                    $_POST['image'] = $file_path;
                }
                else
                {
                    debug ("no image to upload");
                    $file_path = $_POST['old_image'];
                }

        if (isset($_POST['image'])) debug ("POST image: ".$_POST['image']);
        debug ("file path: ".$file_path);

                if ("" != $thumb['name'])
                {
                    debug ("there is a thumb to upload");
                    if (file_exists($doc_root.$upl_pics_dir."photos/".$thumb['name'])) $if_thumb_exists = 1;
                    $thumb_path = upload_file($thumb['name'],$thumb['tmp_name'],$home,$upl_pics_dir."photos/",$if_thumb_exists);
                    debug ("size: ".filesize($home.$thumb_path));

                    if (filesize($home.$thumb_path) > $max_file_size)
                    {
                        debug ("thumb size > max file size!");
                        $content['result'] .= "Простите, но нельзя закачать файл размером больше ".($max_file_size / 1024)." килобайт";
                        if (unlink ($home.$thumb_path)) debug ("thumb deleted");
                        else debug ("can't delete thumb!");
                        $thumb_path = $_POST['old_thumb'];
                    }

                    $_POST['thumb'] = $thumb_path;
                }
                else
                {
                    debug ("no thumb to upload");
                    $thumb_path = $_POST['old_thumb'];
                }

        if (isset($_POST['thumb'])) debug ("POST thumb: ".$_POST['thumb']);
        debug ("thumb path: ".$thumb_path);
        
            debug ("have data to update");
            if ("" != $_POST['name'])
            {
                debug ("photo name isn't empty");
                exec_query("UPDATE ksh_photos set name='".mysql_real_escape_string($_POST['name'])."',  descr='".mysql_real_escape_string($_POST['descr'])."', image='".mysql_real_escape_string($file_path)."', thumb='".mysql_real_escape_string($thumb_path)."' WHERE id='".mysql_real_escape_string($photo_id)."'");
                $content['result'] .= "Изменения записаны";
            }
            else
            {
                debug ("photo name is empty");
                $content['result'] .= "Пожалуйста, задайте название фотографии";
            }
        }
        else
        {
            debug ("no data to update");
        }

            $result = exec_query("SELECT * FROM ksh_photos WHERE id='".mysql_real_escape_string($photo_id)."'");
            $photo = mysql_fetch_array($result);
            mysql_free_result($result);
            $content['name'] = stripslashes($photo['name']);
            $content['descr'] = stripslashes($photo['descr']);
            $content['id'] = stripslashes($photo['id']);
            $content['gallery_id'] = stripslashes($photo['gallery']);

            $content['gallery'] = stripslashes(mysql_result(exec_query("SELECT name FROM ksh_photos_galleries WHERE id='".mysql_real_escape_string($photo['gallery'])."'"), 0, 0));

            $content['image'] = stripslashes($photo['image']);
            $content['thumb'] = stripslashes($photo['thumb']);

    }
    else
    {
        debug ("user isn't admin");
        $content['result'] = "Пожалуйста, войдите в систему как администратор";
    }

    debug ("*** end: photos_edit ***");
    return $content;
}

function photos_view()
{
	global $user;
	global $config;
	debug ("*** photos_view ***");
	
	$content = array(
		'if_show_admin_link' => '',
		'id' => '',
		'name' => '',
		'author' => '',
		'gallery' => '',
		'image' => '',
		'thumb' => '',
		'descr' => '',
		'date' => ''
	);

	if (1 == $user['id'])
		$content['if_show_admin_link'] = "yes";
	
	if (isset($_GET['photo']))
		$photo_id = $_GET['photo'];
	else
		$photo_id = 0;

	$sql_query = "SELECT * FROM `ksh_photos` WHERE `id` = '".mysql_real_escape_string($photo_id)."'";
	$result = exec_query($sql_query);
	$photo = mysql_fetch_array($result);
	mysql_free_result($result);

	$content['id'] = stripslashes($photo['id']);
	$content['name'] = stripslashes($photo['name']);
	$content['author'] = stripslashes($photo['author']);
	$content['gallery'] = stripslashes($photo['gallery']);
	$content['image'] = stripslashes($photo['image']);
	$content['thumb'] = stripslashes($photo['thumb']);
	$content['descr'] = stripslashes($photo['descr']);
	$content['date'] = stripslashes($photo['date']);

	debug ("*** end: photos_view ***");
	return $content;
}


?>
