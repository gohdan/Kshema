<?php

// Guestbook class

class Guestbook
{

function add()
{
	global $user;
	global $config;
	debug ("*** guestbook: add ***");
	$content = array(
		'content' => '',
		'result' => '',
		'categories_select' => '',
		'category' => '',
		'show_admin_link' => '',
		'category_link' => '',
		'session_name' => '',
		'session_id' => '',
		'name' => '',
		'title' => '',
		'contact' => '',
		'text' => ''
	);
	$result = 1;
	$cat = new Category();

	$priv = new Privileges();

	$content['session_name'] = session_name();
	$content['session_id'] = session_id();

	if ($priv -> has("guestbook", "admin", "write"))
		$content['show_admin_link'] = "yes";

	if ($priv -> has("guestbook", "add", "write"))
	{
		debug ("user is admin");
		if (isset($_POST['do_add']))
		{
			if(isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] ==  $_POST['keystring'])
				$result = 1;
			else
			{
				$result = 0;
				$content['result'] .= "Неправильно введено проверочное слово.";
			}

			if ("" == $_POST['name'] || "" == $_POST['text'] || "" == $_POST['title'])
			{
				$result = 0;
				$content['result'] .= "Заполнены не все поля, отмеченные звёздочкой.";
			}

			if ($result)
			{
				$sql_query = "INSERT INTO `ksh_guestbook` (
				`category`,
				`user`,
				`name`,
				`contact`,
				`datetime`,
				`title`,
				`text`
				) VALUES (
				'".mysql_real_escape_string($_POST['category'])."',
				'".mysql_real_escape_string($user['id'])."',
				'".mysql_real_escape_string($_POST['name'])."',
				'".mysql_real_escape_string($_POST['contact'])."',
				'".mysql_real_escape_string(date("Y-m-d H:i:s"))."',
				'".mysql_real_escape_string($_POST['title'])."',
				'".mysql_real_escape_string($_POST['text'])."'
				)";
				exec_query($sql_query);
				if (0 == mysql_errno())
					$content['result'] .= "Сообщение успешно добавлено";
				else
					$content['result'] .= "Не удалось добавить сообщение, ошибка базы данных";
			}
			else
			{
				unset($_SESSION['captcha_keystring']);
				$content['name'] = $_POST['name'];
				$content['contact'] = $_POST['contact'];
				$content['title'] = $_POST['title'];
				$content['text'] = $_POST['text'];
			}
		}
	}

	if (isset($_GET['category']))
		$category = $_GET['category'];
	else if (isset($_POST['category']))
		$category = $_POST['category'];
	else
		$category = 0;

	$content['category'] = $category;
	$category_name = $cat -> get_name("ksh_guestbook_categories", $category);
	if ("" != $category_name && NULL != $category_name)
		$content['category_link'] = $category_name;
	else
		$content['category_link'] = $category;


	debug ("*** end: guestbook: add ***");
	return $content;	
}

function edit()
{
	global $user;
	global $config;
	debug ("*** guestbook: edit ***");
	$content = array(
		'content' => '',
		'result' => '',
		'show_admin_link' => '',
		'id' => '',
		'title' => '',
		'text' => '',
		'messages' => '',
		'category_title' => '',
		'category' => '',
		'bbs' => ''
	);

	$cat = new Category();
	$priv = new Privileges();


	if ($priv -> has("guestbook", "admin", "write"))
		$content['show_admin_link'] = "yes";

	$id = 0;
	if (isset($_GET['element']))
		$id = $_GET['element'];
	
	if (isset($_POST['id']))
		$id = $_POST['id'];

	if (isset($_POST['do_update']))
	{
		debug ("have message to update");
		if ($priv -> has("guestbook", "edit", "write"))
		{
			debug ("user has write rights");

			$sql_query = "UPDATE `ksh_guestbook` SET
				`name` = '".mysql_real_escape_string($_POST['name'])."',
				`contact` = '".mysql_real_escape_string($_POST['contact'])."',
				`title` = '".mysql_real_escape_string($_POST['title'])."',
				`category` = '".mysql_real_escape_string($_POST['category'])."',
				`text` = '".mysql_real_escape_string($_POST['text'])."'
				WHERE `id` = '".mysql_real_escape_string($_POST['id'])."'";
			exec_query($sql_query);
			if (0 == mysql_errno())
				$content['result'] = "Изменение успешно записано";
			else
				$content['result'] = "Не удалось обновить запись, ошибка базы данных";
		}
		else
			debug ("user doesn't have admin rights");
	}

	$sql_query = "SELECT * FROM `ksh_guestbook` WHERE `id` = '".mysql_real_escape_string($id)."'";
	$result = exec_query($sql_query);
	$row = mysql_fetch_array($result);
	mysql_free_result($result);

	$content['category'] = stripslashes($row['category']);
	debug("category: ".$content['category']);
	$content['category_title'] = $cat -> get_title("ksh_guestbook_categories", $content['category']);
	debug("category title: ".$content['category_title']);
	$content['category_name'] = $cat -> get_name("ksh_guestbook_categories", $content['category']);
	debug("category name: ".$content['category_name']);
	if ("" != $content['category_name'] && NULL != $content['category_name'])
		$content['category_link'] = $content['category_name'];
	else
		$content['category_link'] = stripslashes($row['category']);

	$content['id'] = stripslashes($row['id']);
	$content['datetime'] = stripslashes($row['datetime']);
	$content['name'] = stripslashes($row['name']);
	$content['contact'] = stripslashes($row['contact']);
	$content['title'] = stripslashes($row['title']);
	$content['text'] = stripslashes($row['text']);


	debug ("*** end: guestbook: edit ***");
	return $content;	
}

function del()
{
	global $user;
	global $config;
	debug ("*** guestbook: del ***");
	$content = array(
		'content' => '',
		'result' => '',
		'id' => '',
		'title' => '',
		'category' => '',
		'category_link' => '',
		'show_admin_link' => ''
	);

	$priv = new Privileges();
	if ($priv -> has ("guestbook", "admin", "write"))
		$content['show_admin_link'] = "yes";

	$id = $_GET['element'];
	$sql_query = "SELECT `id`, `title`, `category` FROM `ksh_guestbook` WHERE `id` = '".mysql_real_escape_string($id)."'";
	$result = exec_query($sql_query);
	$row = mysql_fetch_array($result);
	mysql_free_result($result);

	$content['id'] = stripslashes($row['id']);
	$content['title'] = stripslashes($row['title']);
	$content['category'] = stripslashes($row['category']);

	$cat = new Category();
	$category_name = $cat -> get_name("ksh_guestbook_categories", $content['category']);
	if ("" != $category_name && NULL != $category_name)
		$content['category_link'] = $category_name;
	else
		$content['category_link'] = $content['category'];

	debug ("*** end: guestbook: del ***");
	return $content;	
}


function view_by_category()
{
	global $user;
	global $config;
	global $template;
	debug ("*** guestbook: view_by_category ***");
	$content = array(
		'content' => '',
		'heading' => '',
		'result' => '',
		'show_admin_link' => '',
		'category_title' => '',
		'category_id' => '',
		'messages' => '',
		'pages' => ''
	);

	$priv = new Privileges();
	if ($priv -> has("guestbook", "admin", "write"))
		$content['show_admin_link'] = "yes";

	$content['heading'] = "Просмотр сообщений";

	if(isset($_GET['category']))
	{
		$category = $_GET['category'];
		if (!is_numeric($category))
		{
			$sql_query = "SELECT `id` FROM `ksh_guestbook_categories` WHERE `name` = '".mysql_real_escape_string($category)."'";
			$result = exec_query($sql_query);
			$row = mysql_fetch_array($result);
			mysql_free_result($result);
			$category = stripslashes($row['id']);
		}
	}
	else
		$category = 0;
	debug ("category: ".$category);

	if ($category)
	{
		// Get category info
	
		$sql_query = "SELECT * FROM `ksh_guestbook_categories` WHERE `id` = '".mysql_real_escape_string($category)."'";
		$result = exec_query($sql_query);
		$row = mysql_fetch_array($result);
		mysql_free_result($result);
		$content['category_title'] = stripslashes($row['title']);
		$template['title'] .= " - ".$content['category_title'];
		$content['category_id'] = stripslashes($row['id']);


		$config['themes']['page_title'] .= " - ".$content['category_title'];		

		// Get pages
		if ((isset($_GET['page'])) && ($_GET['page'] > 1))
		{
			$start_page = $_GET['page'];
			$content['page'] = $_GET['page'];
		}
	    else
			$start_page = 1; // Need to determine correct LIMIT
		$goods_on_page = $config['guestbook']['messages_on_page'];

		$messages_qty = mysql_result(exec_query("SELECT COUNT(*) FROM `ksh_guestbook` WHERE `category` = '".$category."'"), 0, 0);
	    debug ("messages qty: ".$messages_qty);
		if ($messages_qty)
		    $pages_qty = ceil($messages_qty / $goods_on_page);
		else
			$pages_qty = 1;
	    debug ("pages qty: ".$pages_qty);

		// Pages counting

	    if ($pages_qty > 1)
	    {
	        for ($i = 1; $i <= $pages_qty; $i++)
	        {
				$content['pages'][$i]['id'] = $i;

				$sql_query = "SELECT `name` FROM `ksh_guestbook_categories` WHERE `id` = '".mysql_real_escape_string($category)."'";
				$result_cat = exec_query($sql_query);
				$row_cat = mysql_fetch_array($result_cat);
				mysql_free_result($result_cat);
				$cat_name = stripslashes($row_cat['name']);
				if ("" != $cat_name && NULL != $cat_name)
					$content['pages'][$i]['category'] = $cat_name;
				else
					$content['pages'][$i]['category'] = $category;

				if ((!isset($_GET['page']) && ($i == 1)) || ($i == $_GET['page']))
					$content['pages'][$i]['show_link'] = "";
	            else
	                $content['pages'][$i]['show_link'] = "yes";
	        }
	    }
	    // End: Pages counting



		// Get messages
		$sql_query = "SELECT * from `ksh_guestbook`
			WHERE `category` = '".mysql_real_escape_string($category)."'
			ORDER BY `datetime` DESC 
			LIMIT ".mysql_real_escape_string(($start_page - 1) * $goods_on_page).",".$goods_on_page;
		$i = 0;
		$result = exec_query($sql_query);
		while ($row = mysql_fetch_array($result))
		{
			$content['messages'][$i]['id'] = stripslashes($row['id']);
			$content['messages'][$i]['title'] = stripslashes($row['title']);
			$content['messages'][$i]['text'] = stripslashes($row['text']);
			$content['messages'][$i]['datetime'] = stripslashes($row['datetime']);
			$content['messages'][$i]['user'] = stripslashes($row['user']);
			$content['messages'][$i]['name'] = stripslashes($row['name']);
			$content['messages'][$i]['contact'] = stripslashes($row['contact']);

			if ("yes" == $config['base']['ext_links_redirect'])
			{
				include_once($config['modules']['location']."redirect/index.php");
				$content['messages'][$i]['text'] = redirect_links_replace(stripslashes($row['text']));
			}
			else
				$content['messages'][$i]['text'] = stripslashes($row['text']);

			if (($user['id']) && (1 == $user['id'] || $user['id'] == stripslashes($row['user'])))
				$content['messages'][$i]['show_admin_link'] = "yes";
			$i++;
		}
		mysql_free_result($result);
	}

	debug ("*** end: guestbook: view_by_category ***");
	return $content;	
}



}

?>
