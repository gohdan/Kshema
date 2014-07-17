<?php

// Categories administration functions of the "photos" module

function photos_categories_add()
{
    debug ("*** photos_categories_add ***");
    global $user;
    global $config;
	$content = array(
		'content' => '',
		'result' => ''
	);
    
	debug ("user id: ".$user['id']);
    if (1 == $user['id'])
    {
        debug ("user is admin");
        if (isset($_POST['do_add']))
        {
            debug ("have data to add");
            if ("" != $_POST['name'])
            {
                debug ("category name isn't empty");
                exec_query("INSERT INTO ksh_photos_categories (name, title) VALUES ('".mysql_real_escape_string($_POST['name'])."', '".mysql_real_escape_string($_POST['title'])."')");
                $content['result'] .= "Категория добавлена";
            }
            else
            {
                debug ("category name is empty");
                $content['result'] .= "Пожалуйста, задайте имя категории";
            }
        }
    }
    else
    {
        debug ("user isn't admin");
        $content['result'] = "Пожалуйста, войдите в систему как администратор";
    }

    debug ("*** end: photos_categories_add ***");
    return $content;
}

function photos_categories_view()
{
    debug ("*** photos_categories_view ***");
    global $user;
    global $config;
	$content = array(
		'content' => '',
		'result' => '',
		'categories' => '',
        'galleries' => ''
	);
	$i = 0;    

    if (1 == $user['id'])
    {
        debug ("user is admin");

        $result = exec_query("SELECT * FROM ksh_photos_categories");
        while ($category = mysql_fetch_array($result))
        {
			$content['categories'][$i]['id'] = stripslashes($category['id']);
			$content['categories'][$i]['name'] = stripslashes($category['name']);
			$content['categories'][$i]['title'] = stripslashes($category['title']);
			if (1 == $user['id'])
			{
				$content['categories'][$i]['edit_link'] =  "<a href=\"/index.php?module=photos&action=category_edit&category=".$category['id']."\">Редактировать</a>";
			}
			else $content['categories'][$i]['edit_link'] = "";
			$i++;
        }
        mysql_free_result($result);
    }
    else
    {
        debug ("user isn't admin");
        $content['result'] .= "Пожалуйста, войдите в систему как администратор";
    }

    debug ("*** end: photos_categories_view ***");
    return $content;
}

function photos_categories_edit()
{
    debug ("*** fn: photos_categories_edit ***");
    global $user;
    global $config;
	$content = array(
		'content' => '',
		'result' => '',
		'category_id' => '',
		'name' => '',
		'title' => ''
	);

    if (isset($_GET['category'])) $category_id =$_GET['category'];
    else if (isset($_POST['id'])) $category_id =$_POST['id'];
    else $category_id =0;
    debug ("category id: ".$category_id);

    debug ("user id: ".$user['id']);
    if (1 == $user['id'])
    {
        debug ("user is admin");
        if (isset($_POST['do_update']))
        {
            debug ("have data to update");
            if ("" != $_POST['name'])
            {
                debug ("category name isn't empty");
                exec_query("UPDATE ksh_photos_categories set name='".mysql_real_escape_string($_POST['name'])."', title='".mysql_real_escape_string($_POST['title'])."' WHERE id='".mysql_real_escape_string($category_id)."'");
                $content['result'] .= "Изменения записаны";
            }
            else
            {
                debug ("category name is empty");
                $content['result'] .= "Пожалуйста, задайте название категории";
            }
        }
        else
        {
            debug ("no data to update");
        }

            $result = exec_query("SELECT * FROM ksh_photos_categories WHERE id='".mysql_real_escape_string($category_id)."'");
            $category = mysql_fetch_array($result);
            $content['category_id'] = stripslashes($category['id']);
            $content['name'] = stripslashes($category['name']);
            $content['title'] = stripslashes($category['title']);
            mysql_free_result($result);
    }
    else
    {
        debug ("user isn't admin");
        $content['result'] = "Пожалуйста, войдите в систему как администратор";
    }

    debug ("*** end: photos_categories_edit ***");
    return $content;
}


?>