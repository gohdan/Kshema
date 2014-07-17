<?php

// galleries administration functions of the "photos" module

function photos_galleries_add()
{
    debug ("*** photos_galleries_add ***");
    global $user;
    global $config;
	$content = array(
		'content' => '',
		'result' => '',
		'descr' => ''
	);

    if (isset($_GET['category'])) $content['category_id'] = $_GET['category'];
    else if (isset($_POST['category'])) $content['category_id'] = $_POST['category'];
    else $content['category_id'] = 0;

    debug ("user id: ".$user['id']);
    if (1 == $user['id'])
    {
        debug ("user is admin");
        if (isset($_POST['do_add']))
        {
            debug ("have data to add");
            if ("" != $_POST['name'])
            {
                debug ("gallery name isn't empty");
                exec_query("INSERT INTO ksh_photos_galleries (name, category, descr) VALUES ('".mysql_real_escape_string($_POST['name'])."', '".mysql_real_escape_string($_POST['category'])."', '".mysql_real_escape_string($_POST['descr'])."')");
                $content['result'] .= "Галерея добавлена";
            }
            else
            {
                debug ("gallery name is empty");
                $content['result'] .= "Пожалуйста, задайте имя галереи";
            }
        }
    }
    else
    {
        debug ("user isn't admin");
        $content['result'] = "Пожалуйста, войдите в систему как администратор";
    }

    debug ("*** end: photos_galleries_add ***");
    return $content;
}

function photos_galleries_view()
{
    debug ("*** photos_galleries_view ***");
    global $user;
    global $config;
	$content = array(
		'content' => '',
		'result' => '',
		'galleries' => ''
	);
	$i = 0;

    if (1 == $user['id'])
    {
        debug ("user is admin");

        $result = exec_query("SELECT * FROM ksh_photos_galleries");
        while ($gallery = mysql_fetch_array($result))
        {
			$content['galleries'][$i]['id'] = stripslashes($gallery['id']);
			$content['galleries'][$i]['name'] = stripslashes($gallery['name']);
			if (1 == $user['id']) $content['galleries'][$i]['edit_link'] = "<a href=\"/index.php?module=photos&action=gallery_edit&gallery=".$gallery['id']."\">Редактировать</a>";
			$i++;
        }
        mysql_free_result($result);
    }
    else
    {
        debug ("user isn't admin");
        $content['result'] = "Пожалуйста, войдите в систему как администратор";
    }

    debug ("*** end: photos_galleries_view ***");
    return $content;
}

function photos_gallery_view()
{
    debug ("*** photos_gallery_view ***");
    global $user;
    global $config;
	global $page_title;
	$content = array(
		'content' => '',
		'result' => '',
		'photos' => '',
		'descr' => '',
		'gallery' => '',
		'add_photo_link' => ''
	);
	$i = 0;

    $content['gallery'] = stripslashes(mysql_result(exec_query("SELECT name FROM ksh_photos_galleries WHERE id='".mysql_real_escape_string($_GET['gallery'])."'"), 0, 0));
    $content['descr'] = stripslashes(mysql_result(exec_query("SELECT descr FROM ksh_photos_galleries WHERE id='".mysql_real_escape_string($_GET['gallery'])."'"), 0, 0));

    if (1 == $user['id'])
    {
        debug ("user is admin");

        if (isset($_POST['do_del']))
        {
            debug ("have photo to delete");
            exec_query("DELETE FROM ksh_photos WHERE id='".mysql_real_escape_string($_POST['id'])."'");
            $content['result'] .= "Фотография успешно удалена";
        }
        else
        {
            debug ("don't have photos to delete");
        }

        $content['add_photo_link'] .= "<a href=\"/index.php?module=photos&action=add&gallery=".$_GET['gallery']."\">Добавить фотографию</a>";
    }
        $result = exec_query("SELECT * FROM ksh_photos WHERE gallery='".mysql_real_escape_string($_GET['gallery'])."' ORDER BY `id`");
        while ($photo = mysql_fetch_array($result))
        {
			$content['photos'][$i]['id'] = stripslashes($photo['id']);
			$content['photos'][$i]['name'] = stripslashes($photo['name']);
			$content['photos'][$i]['thumb'] = stripslashes($photo['thumb']);
            if ("" != $photo['image'])
                $content['photos'][$i]['image'] = "<img src=\"".stripslashes($photo['image'])."\"  alt=\"".stripslashes($photo['name'])."\">";
			$content['photos'][$i]['descr'] = stripslashes($photo['descr']);
            
            if (1 == $user['id'])
            {
				$content['photos'][$i]['edit_link'] = "<a href=\"/index.php?module=photos&action=edit&photo=".$photo['id']."\">Редактировать</a>";
				$content['photos'][$i]['del_link'] = "<a href=\"/index.php?module=photos&action=del&photo=".$photo['id']."\">Удалить</a>";
            }
			else
			{
				$content['photos'][$i]['edit_link'] = "";
				$content['photos'][$i]['del_link'] = "";
			}
			$i++;
        }
        mysql_free_result($result);

	$page_title .= " | ".$content['gallery'];

    debug ("*** end: photos_gallery_view ***");
    return $content;
}


function photos_galleries_view_by_category()
{
    debug ("*** photos_galleries_view_by_category ***");
    global $user;
    global $config;
	global $page_title;
	$content = array(
		'content' => '',
		'galleries' => '',
		'category' => '',
		'full_text' => ''
	);
	$i = 0;

    if (1 == $user['id'])
    {
        debug ("user is admin");
    }
        else
    {
        debug ("user isn't admin");
        //$content['content'] = "<p>Пожалуйста, войдите в систему как администратор.</p>";
    }
        if (isset($_GET['category'])) $content['category_id'] = $_GET['category'];
        else if (isset($_POST['category'])) $content['category_id'] = $_POST['category'];
        else $content['category_id'] = 0;
        $content['category'] = stripslashes(mysql_result(exec_query("SELECT title FROM ksh_photos_categories WHERE id='".mysql_real_escape_string($_GET['category'])."'"), 0, 0));
		
        $result = exec_query("SELECT * FROM ksh_photos_galleries WHERE category='".mysql_real_escape_string($_GET['category'])."'");
        while ($gallery = mysql_fetch_array($result))
        {
			$content['galleries'][$i]['id'] = stripslashes($gallery['id']);
			$content['galleries'][$i]['name'] = stripslashes($gallery['name']);
            if (1 == $user['id'])
				$content['galleries'][$i]['edit_link'] = "<a href=\"/index.php?module=photos&action=gallery_edit&gallery=".$gallery['id']."\">Редактировать</a>";
			else
				$content['galleries'][$i]['edit_link'] = "";
			$i++;
        }
        mysql_free_result($result);


	$page_title .= " | ".$content['category'];

    debug ("*** end: photos_galleries_view_by_category ***");
    return $content;
}

function photos_galleries_edit()
{
    debug ("*** photos_galleries_edit ***");
    global $user;
    global $config;
	$content = array(
		'content' => '',
		'result' => '',
		'gallery_id' => '',
		'name' => '',
		'descr' => ''
	);

    if (isset($_GET['gallery'])) $gallery_id =$_GET['gallery'];
    else if (isset($_POST['id'])) $gallery_id =$_POST['id'];
    else $gallery_id =0;
    debug ("gallery id: ".$gallery_id);

    debug ("user id: ".$user['id']);
    if (1 == $user['id'])
    {
        debug ("user is admin");
        if (isset($_POST['do_update']))
        {
            debug ("have data to update");
            if ("" != $_POST['name'])
            {
                debug ("gallery name isn't empty");
                exec_query("UPDATE ksh_photos_galleries set name='".mysql_real_escape_string($_POST['name'])."', descr='".mysql_real_escape_string($_POST['descr'])."' WHERE id='".mysql_real_escape_string($gallery_id)."'");
                $content['result'] .= "Изменения записаны";
            }
            else
            {
                debug ("gallery name is empty");
                $content['result'] .= "Пожалуйста, задайте название галереи";
            }
        }
        else
        {
            debug ("no data to update");
        }

            $result = exec_query("SELECT * FROM ksh_photos_galleries WHERE id='".mysql_real_escape_string($gallery_id)."'");
            $gallery = mysql_fetch_array($result);
            $content['gallery_id'] = stripslashes($gallery['id']);
            $content['name'] = stripslashes($gallery['name']);
            $content['descr'] = stripslashes($gallery['descr']);
            mysql_free_result($result);
    }
    else
    {
        debug ("user isn't admin");
        $content['result'] = "Пожалуйста, войдите в систему как администратор";
    }

    debug ("*** end: photos_galleries_edit ***");
    return $content;
}

?>
