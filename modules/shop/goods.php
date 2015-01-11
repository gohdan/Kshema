<?php

// Goods function of the "shop" module


function shop_goods_view_all()
{
	debug ("*** shop_goods_view_all ***");
	global $user;
	global $config;
	$content = array(
		'result' => '',
		'content' => '',
		'all_goods' => '',
		'show_admin_link' => '',
		'show_add_link' => ''
	);
	if (1 == $user['id'])
	{
		debug ("user is admin");
		$content['show_admin_link'] = "yes";
		$content['show_add_link'] = "yes";
	}
	else
		debug ("user isn't admin");

	if (isset($_POST['do_del']))
	{
		if (1 == $user['id'])
		{
			debug ("user is admin, deleting from DB");
			exec_query ("delete from ksh_shop_goods where id='".mysql_real_escape_string($_POST['id'])."'");
			$content['result'] = "Товар удалён";
		}
		else
		{
			debug ("user isn't admin, doing nothing");
			$content['result'] = "Товар не удалён";
			$content['content'] = "Пожалуйста, войдите в систему как администратор";
		}
	}

	$content['all_goods'] = shop_goods_list();

	foreach ($content['all_goods'] as $k => $v)
	{
		if (1 == $user['id'])
		{
			$content['all_goods'][$k]['show_edit_link'] = "yes";
			$content['all_goods'][$k]['show_del_link'] = "yes";
		}
	}

	debug ("*** end:shop_goods_view_all ***");
	return $content;
}

function shop_goods_add()
{
	debug ("*** shop_goods_add ***");
	global $user;
	global $config;
	$content = array(
		'result' => '',
		'content' => '',
		'authors' => '',
		'categories' => ''
	);

	/* Image uploading funcs */

	global $upl_pics_dir;
    global $doc_root;
    global $max_file_size;
    global $home;

    if (isset($_FILES['image'])) $image = $_FILES['image'];
    if (isset($_FILES['images'])) $images = $_FILES['images'];
    if (isset($_FILES['pdf'])) $pdf = $_FILES['pdf'];
    if (isset($_FILES['epub'])) $epub = $_FILES['epub'];
    if (isset($_FILES['mp3'])) $mp3 = $_FILES['mp3'];

    $if_file_exists = 0;
    $file_path = "";

	if ("" != $image['name'])
	{
		debug ("there is an image to upload");
		if (file_exists($doc_root.$upl_pics_dir."shop/".$image['name'])) $if_file_exists = 1;
		$file_path = upload_file($image['name'],$image['tmp_name'],$home,$upl_pics_dir."shop/",$if_file_exists);
		debug ("size: ".filesize($home.$file_path));

		if (filesize($home.$file_path) > $max_file_size)
		{
			debug ("file size > max file size!");
			$content['content'] .= "<p>Простите, но нельзя закачать файл размером больше ".($max_file_size / 1024)." килобайт</p>";
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

	$if_file_exists = 0;
	if ("" != $images['name'])
	{
		debug ("there is an additional image to upload");
		if (file_exists($doc_root.$upl_pics_dir."shop/".$images['name'])) $if_file_exists = 1;
		$images_path = upload_file($images['name'],$images['tmp_name'],$home,$upl_pics_dir."shop/",$if_file_exists);
		debug ("size: ".filesize($home.$file_path));

		if (filesize($home.$images_path) > $max_file_size)
		{
			debug ("file size > max file size!");
			$content['content'] .= "<p>Простите, но нельзя закачать файл размером больше ".($max_file_size / 1024)." килобайт</p>";
			if (unlink ($home.$images_path)) debug ("file deleted");
			else debug ("can't delete file!");
			$images_path = "";
		}

		$_POST['images'] = $images_path;
	}
	else
	{
		debug ("no additional images to upload");
		$file_path = $_POST['image'];
	}

	$if_file_exists = 0;
	$pdf_path = "";
	if ("" != $pdf['name'])
	{
		debug ("there is a pdf to upload");
		if (file_exists($doc_root.$upl_pics_dir."shop/pdf/".$pdf['name'])) $if_file_exists = 1;
		$pdf_path = upload_file($pdf['name'],$pdf['tmp_name'],$home,$upl_pics_dir."shop/pdf/",$if_file_exists);
		debug ("size: ".filesize($home.$pdf_path));

		if (filesize($home.$pdf_path) > $max_file_size)
		{
			debug ("file size > max file size!");
			$content['content'] .= "<p>Простите, но нельзя закачать файл размером больше ".($max_file_size / 1024)." килобайт</p>";
			if (unlink ($home.$pdf_path)) debug ("file deleted");
			else debug ("can't delete file!");
			$pdf_path = "";
		}

		$_POST['pdf'] = $pdf_path;
	}
	else
	{
		debug ("no additional images to upload");
		$pdf_path = $_POST['pdf'];
	}


	$if_file_exists = 0;
	$epub_path = "";
	if ("" != $epub['name'])
	{
		debug ("there is a epub to upload");
		if (file_exists($doc_root.$upl_pics_dir."shop/epub/".$epub['name'])) $if_file_exists = 1;
		$epub_path = upload_file($epub['name'],$epub['tmp_name'],$home,$upl_pics_dir."shop/epub/",$if_file_exists);
		debug ("size: ".filesize($home.$epub_path));

		if (filesize($home.$epub_path) > $max_file_size)
		{
			debug ("file size > max file size!");
			$content['content'] .= "<p>Простите, но нельзя закачать файл размером больше ".($max_file_size / 1024)." килобайт</p>";
			if (unlink ($home.$epub_path)) debug ("file deleted");
			else debug ("can't delete file!");
			$epub_path = "";
		}

		$_POST['epub'] = $epub_path;
	}
	else
	{
		debug ("no additional images to upload");
		$epub_path = $_POST['epub'];
	}


	$if_file_exists = 0;
	$mp3_path = "";
	if ("" != $mp3['name'])
	{
		debug ("there is a mp3 to upload");
		if (file_exists($doc_root.$upl_pics_dir."shop/mp3/".$mp3['name'])) $if_file_exists = 1;
		$mp3_path = upload_file($mp3['name'],$mp3['tmp_name'],$home,$upl_pics_dir."shop/mp3/",$if_file_exists);
		debug ("size: ".filesize($home.$mp3_path));

		if (filesize($home.$mp3_path) > $max_file_size)
		{
			debug ("file size > max file size!");
			$content['content'] .= "<p>Простите, но нельзя закачать файл размером больше ".($max_file_size / 1024)." килобайт</p>";
			if (unlink ($home.$mp3_path)) debug ("file deleted");
			else debug ("can't delete file!");
			$mp3_path = "";
		}

		$_POST['mp3'] = $mp3_path;
	}
	else
	{
		debug ("no additional images to upload");
		$mp3_path = $_POST['mp3'];
	}


	/* End: Image uploading funcs */


	if (1 == $user['id'])
	{
		debug ("user is admin");
	}
	else
		debug ("user isn't admin");

	if (isset($_POST['do_add']))
	{
		if (1 == $user['id'])
		{
			debug ("user is admin, inserting into DB");

	        unset ($_POST['do_add']);

			if ("" != $_POST['new_link_title'] && "" != $_POST['new_link_url'])
				$_POST['links'] .= $_POST['new_link_title'] . "|" . $_POST['new_link_img']. "|" . $_POST['new_link_url'];
			unset($_POST['new_link_title']);
			unset($_POST['new_link_img']);
			unset($_POST['new_link_url']);
			debug ("link: ".$_POST['links']);

        	foreach ($_POST as $k => $v)
        	{
	            $fields .= $k.",";
            	$values .= "'".mysql_real_escape_string($v)."',";
        	}

        	$sql_query = "INSERT INTO ksh_shop_goods (".ereg_replace(",$","",$fields).") values (".ereg_replace(",$","",$values).")";

        	exec_query ($sql_query);

			$content['result'] = "Товар добавлен";

			if (in_array("rss", $config['modules']['installed']) && "yes" == $config['rss']['use'])
			{
				include_once($config['modules']['location']."/rss/index.php");
				rss_add($_POST['name'], $config['base']['site_url']."/shop/view_good/good:".mysql_insert_id(), $_POST['commentary'], date("Y-m-d"));
			}
		}
		else
		{
			debug ("user isn't admin, doing nothing");
			$content['result'] = "Товар не добавлен";
			$content['content'] = "Пожалуйста, войдите в систему как администратор";
		}
	}

	$authors = shop_authors_list();
	foreach ($authors as $k => $v)
	{
		if (isset($_POST['author']) && $v['id'] == $_POST['author'])
			$if_selected = " selected";
		else
			$if_selected = "";

		$content['authors'] .= "<option value=\"".$v['id']."\"".$if_selected.">".$v['name']."</option>";
	}

	$categories = shop_categories_list();
	foreach ($categories as $k => $v)
	{
		if (isset($_POST['category']) && $v['id'] == $_POST['category'])
			$if_selected = " selected";
		else
			$if_selected = "";
		$content['categories'] .= "<option value=\"".$v['id']."\"".$if_selected.">".$v['name']."</option>";
	}

	debug ("*** end:shop_goods_add ***");
	return $content;
}

function shop_goods_edit()
{
	debug ("*** shop_goods_edit ***");
	global $user;
	global $config;
	$content = array(
		'result' => '',
		'content' => '',
		'id' => '',
		'name' => '',
		'image' => '',
		'images' => '',
		'authors' => '',
		'categories' => '',
		'genre' => '',
		'original_name' => '',
		'format' => '',
		'language' => '',
		'year' => '',
		'publisher' => '',
		'pages_qty' => '',
		'weight' => '',
		'new_qty' => '',
		'new_price' => '',
		'used_qty' => '',
		'used_price' => '',
		'commentary' => '',
		'if_new' => '',
		'if_popular' => '',
		'if_recommended' => '',
		'if_hide' => '',
		'pdf' => '',
		'epub' => '',
		'mp3' => '',
		'embed' => '',
		'tags' => ''
	);


    global $upl_pics_dir;
    global $doc_root;
    global $max_file_size;
    global $home;

    if (isset($_FILES['image'])) $image = $_FILES['image'];
    if (isset($_FILES['images'])) $images = $_FILES['images'];
    if (isset($_FILES['pdf'])) $pdf = $_FILES['pdf'];
    if (isset($_FILES['epub'])) $epub = $_FILES['epub'];
    if (isset($_FILES['mp3'])) $mp3 = $_FILES['mp3'];

	if (isset($_POST['images_del']))
	{
		$_POST['images'] = "";
		unset($_POST['images_del']);
	}
	if (isset($_POST['pdf_del']))
	{
		$_POST['pdf'] = "";
		unset($_POST['pdf_del']);
	}
	if (isset($_POST['epub_del']))
	{
		$_POST['epub'] = "";
		unset($_POST['epub_del']);
	}
	if (isset($_POST['mp3_del']))
	{
		$_POST['mp3'] = "";
		unset($_POST['mp3_del']);
	}

    $if_file_exists = 0;
    $file_path = "";

	if ("" != $image['name'])
	{
		debug ("there is an image to upload");
		if (file_exists($doc_root.$upl_pics_dir."shop/".$image['name'])) $if_file_exists = 1;
		$file_path = upload_file($image['name'],$image['tmp_name'],$home,$upl_pics_dir."shop/",$if_file_exists);
		debug ("size: ".filesize($home.$file_path));

		if (filesize($home.$file_path) > $max_file_size)
		{
			debug ("file size > max file size!");
			$content['content'] .= "<p>Простите, но нельзя закачать файл размером больше ".($max_file_size / 1024)." килобайт</p>";
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

	$if_file_exists = 0;
	if ("" != $images['name'])
	{
		debug ("there is an additional image to upload");
		if (file_exists($doc_root.$upl_pics_dir."shop/".$images['name'])) $if_file_exists = 1;
		$images_path = upload_file($images['name'],$images['tmp_name'],$home,$upl_pics_dir."shop/",$if_file_exists);
		debug ("size: ".filesize($home.$file_path));

		if (filesize($home.$images_path) > $max_file_size)
		{
			debug ("file size > max file size!");
			$content['content'] .= "<p>Простите, но нельзя закачать файл размером больше ".($max_file_size / 1024)." килобайт</p>";
			if (unlink ($home.$images_path)) debug ("file deleted");
			else debug ("can't delete file!");
			$images_path = "";
		}

		$_POST['images'] = $images_path;
	}
	else
	{
		debug ("no additional images to upload");
		$file_path = $_POST['image'];
	}

	$if_file_exists = 0;
	$pdf_path = "";
	if ("" != $pdf['name'])
	{
		debug ("there is a pdf to upload");
		if (file_exists($doc_root.$upl_pics_dir."shop/pdf/".$pdf['name'])) $if_file_exists = 1;
		$pdf_path = upload_file($pdf['name'],$pdf['tmp_name'],$home,$upl_pics_dir."shop/pdf/",$if_file_exists);
		debug ("size: ".filesize($home.$pdf_path));

		if (filesize($home.$pdf_path) > $max_file_size)
		{
			debug ("file size > max file size!");
			$content['content'] .= "<p>Простите, но нельзя закачать файл размером больше ".($max_file_size / 1024)." килобайт</p>";
			if (unlink ($home.$pdf_path)) debug ("file deleted");
			else debug ("can't delete file!");
			$pdf_path = "";
		}

		$_POST['pdf'] = $pdf_path;
	}
	else
	{
		debug ("no additional pdf to upload");
		$pdf_path = $_POST['pdf'];
	}

	$if_file_exists = 0;
	$epub_path = "";
	if ("" != $epub['name'])
	{
		debug ("there is a epub to upload");
		if (file_exists($doc_root.$upl_pics_dir."shop/epub/".$epub['name'])) $if_file_exists = 1;
		$epub_path = upload_file($epub['name'],$epub['tmp_name'],$home,$upl_pics_dir."shop/epub/",$if_file_exists);
		debug ("size: ".filesize($home.$epub_path));

		if (filesize($home.$pdf_path) > $max_file_size)
		{
			debug ("file size > max file size!");
			$content['content'] .= "<p>Простите, но нельзя закачать файл размером больше ".($max_file_size / 1024)." килобайт</p>";
			if (unlink ($home.$epub_path)) debug ("file deleted");
			else debug ("can't delete file!");
			$pdf_path = "";
		}

		$_POST['epub'] = $epub_path;
	}
	else
	{
		debug ("no additional pdf to upload");
		$epub_path = $_POST['epub'];
	}

	$if_file_exists = 0;
	$mp3_path = "";
	if ("" != $mp3['name'])
	{
		debug ("there is a mp3 to upload");
		if (file_exists($doc_root.$upl_pics_dir."shop/mp3/".$mp3['name'])) $if_file_exists = 1;
		$mp3_path = upload_file($mp3['name'],$mp3['tmp_name'],$home,$upl_pics_dir."shop/mp3/",$if_file_exists);
		debug ("size: ".filesize($home.$mp3_path));

		if (filesize($home.$mp3_path) > $max_file_size)
		{
			debug ("file size > max file size!");
			$content['content'] .= "<p>Простите, но нельзя закачать файл размером больше ".($max_file_size / 1024)." килобайт</p>";
			if (unlink ($home.$mp3_path)) debug ("file deleted");
			else debug ("can't delete file!");
			$mp3_path = "";
		}

		$_POST['mp3'] = $mp3_path;
	}
	else
	{
		debug ("no additional pdf to upload");
		$mp3_path = $_POST['mp3'];
	}

	if (1 == $user['id'])
	{
		debug ("user is admin");
	}
	else
		debug ("user isn't admin");

	if (isset($_POST['do_update']))
	{
		if (1 == $user['id'])
		{
			$id = mysql_real_escape_string($_POST['id']);
        	unset ($_POST['do_update']);
        	unset ($_POST['id']);

			/* Links processing */

			$links = "";
			if (isset($_POST['links']))
				foreach($_POST['links'] as $k => $v)
				{
					if (("" != $_POST['link_title_'.$v]) && ("" != $_POST['link_url_'.$v]))
						$links .= $_POST['link_title_'.$v] . "|" . $_POST['link_img_'.$v] .  "|" . $_POST['link_url_'.$v] . "|";
					unset($_POST['link_title_'.$v]);
					unset($_POST['link_img_'.$v]);
					unset($_POST['link_url_'.$v]);
				}

			debug ("links: ".$links);

			if ("" != $_POST['new_link_title'] && "" != $_POST['new_link_url'])
				$links .= $_POST['new_link_title'] . "|" . $_POST['new_link_img'] . "|" . $_POST['new_link_url'] . "|";
			debug ("links: ".$links);

			$_POST['links'] = substr($links, 0, -1);
			debug ("POST links: ".$_POST['links']);
			unset($_POST['new_link_title']);
			unset($_POST['new_link_img']);
			unset($_POST['new_link_url']);

			/* End: Links processing */

        	$sql_query = "UPDATE ksh_shop_goods SET ";
        	foreach ($_POST as $k => $v) $sql_query .= $k."='".mysql_real_escape_string($v)."', ";
        	$sql_query = ereg_replace(", $","",$sql_query)." WHERE id='".$id."'";

        	exec_query ($sql_query);
			$content['result'] = "Изменения записаны";
		}
		else
		{
			debug ("user isn't admin, doing nothing");
			$content['result'] = "Изменения не записаны";
			$content['content'] = "Пожалуйста, войдите в систему как администратор";
		}
	}

	$result = exec_query("SELECT * FROM ksh_shop_goods WHERE id='".mysql_real_escape_string($_GET['goods'])."'");
	$good = mysql_fetch_array($result);
	mysql_free_result($result);

	$content['id'] = stripslashes($good['id']);
	$content['name'] = stripslashes($good['name']);
	$content['image'] = stripslashes($good['image']);
	$content['images'] = stripslashes($good['images']);
	$content['genre'] = stripslashes($good['genre']);
	$content['original_name'] = stripslashes($good['original_name']);
	$content['format'] = stripslashes($good['format']);
	$content['language'] = stripslashes($good['language']);
	$content['year'] = stripslashes($good['year']);
	$content['publisher'] = stripslashes($good['publisher']);
	$content['pages_qty'] = stripslashes($good['pages_qty']);
	$content['weight'] = stripslashes($good['weight']);
	$content['new_qty'] = stripslashes($good['new_qty']);
	$content['new_price'] = stripslashes($good['new_price']);
	$content['used_qty'] = stripslashes($good['used_qty']);
	$content['used_price'] = stripslashes($good['used_price']);
	$content['commentary'] = stripslashes($good['commentary']);
	$content['pdf'] = stripslashes($good['pdf']);
	$content['epub'] = stripslashes($good['epub']);
	$content['mp3'] = stripslashes($good['mp3']);
	$content['embed'] = stripslashes($good['embed']);
	$content['tags'] = stripslashes($good['tags']);

	$content['links_edit'] = shop_goods_links_extract(stripslashes($good['links']));
	debug("links_edit:", 2);
	dump($content['links_edit']);

	if ("1" == stripslashes($good['if_new']))
		$content['if_new'] = "yes";
	else
		$content['if_new'] = "";
	if ("1" == stripslashes($good['if_popular']))
		$content['if_popular'] = "yes";
	else
		$content['if_popular'] = "";
	if ("1" == stripslashes($good['if_hide']))
		$content['if_hide'] = "yes";
	else
		$content['if_hide'] = "";
	if ("1" == stripslashes($good['if_recommended']))
		$content['if_recommended'] = "yes";
	else
		$content['if_recommended'] = "";

	$authors = shop_authors_list();
	foreach ($authors as $k => $v)
	{
		$content['authors'] .= "<option value=\"".$v['id']."\"";
		if ($good['author'] == $v['id']) $content['authors'] .= " selected";
		$content['authors'] .= ">".$v['name']."</option>";
	}

	$categories = shop_categories_list();
	foreach ($categories as $k => $v)
	{
		$content['categories'] .= "<option value=\"".$v['id']."\"";
		if ($good['category'] == $v['id']) $content['categories'] .= " selected";
		$content['categories'] .= ">".$v['name']."</option>";
	}


	debug ("*** end:shop_goods_edit ***");
	return $content;
}

function shop_goods_del()
{
	debug ("*** shop_goods_del ***");
	global $user;
	global $config;
	$content = array(
		'result' => '',
		'content' => '',
		'id' => '',
		'name' => ''
	);
	if (1 == $user['id'])
	{
		debug ("user is admin");
	}
	else
		debug ("user isn't admin");

	$result = exec_query("select name from ksh_shop_goods where id='".mysql_real_escape_string($_GET['goods'])."'");
	$content['id'] = $_GET['goods'];
	$content['name'] = stripslashes(mysql_result($result, 0, 0));
	mysql_free_result ($result);

	debug ("*** end:shop_goods_del ***");
	return $content;
}

function shop_goods_list()
{
	debug ("*** shop_goods_list ***");
    $i = 0;
    $result = exec_query ("select id,name,author,category from ksh_shop_goods order by id");
    while ($good = mysql_fetch_array($result))
    {
        $goods[$i]['id'] = stripslashes($good['id']);
        $goods[$i]['name'] = stripslashes($good['name']);
        $goods[$i]['author'] = stripslashes($good['author']);
        $goods[$i]['category'] = stripslashes($good['category']);
        $goods[$i]['category_name'] = mysql_result(exec_query("SELECT `name` FROM `ksh_shop_categories` WHERE `id` = '".stripslashes($good['category'])."'"), 0, 0);
		$i++;
    }
    mysql_free_result($result);
	debug ("*** end: shop_goods_list ***");
    return $goods;
}

function shop_view_by_categories()
{
	debug ("*** shop_view_by_categories ***");
	global $user;
	global $config;
	$content = array(
		'result' => '',
		'content' => '',
		'category_name' => '',
		'category_id' => '',
		'show_multiple_add_form' => '',
		'show_admin_link' => '',
		'show_add_link' => '',
		'pages' => '',
		'goods_by_category' => ''
	);

	if (1 == $user['id'])
	{
		debug ("user is admin");
		$content['show_admin_link'] = "yes";
		$content['show_add_link'] = "yes";
	}
	else
		debug ("user isn't admin");

	if (isset($_GET['categories']))
		$id = $_GET['categories'];
	else if (isset($_POST['categories']))
		$id = $_POST['categories'];
	else
		$id = 0;

	$content['category_id'] = $id;
	$content['category_name'] = stripslashes(mysql_result(exec_query("SELECT name FROM ksh_shop_categories WHERE id='".$id."'"),0,0));
	$category_template = stripslashes(mysql_result(exec_query("SELECT template FROM ksh_shop_categories WHERE id='".$id."'"),0,0));
	
	if ("" != $category_template)
		$config['themes']['page_tpl'] = $category_template;

	/* Show subcategories */
	$i = 0;
	$sql_query = "SELECT * FROM `ksh_shop_categories` WHERE `parent` = '".mysql_real_escape_string($id)."'";
	$result = exec_query($sql_query);
	while ($row = mysql_fetch_array($result))
	{
		$subcat_id = stripslashes($row['id']);
		$content['subcategories'][$i]['id'] = $subcat_id;
		$content['subcategories'][$i]['name'] = stripslashes($row['name']);

		$last_subcat_goods = shop_view_last($subcat_id);
		$content['subcategories'][$i]['subcategories_last_goods'] = gen_content("shop", "list_subcategories_last_goods", $last_subcat_goods);

		$i++;
	}
	mysql_free_result($result);



	/* End: Show subcategories */


	$goods_on_page = $config['shop']['goods_on_page'];

	if ((isset($_GET['page'])) && ($_GET['page'] > 1))
		$start_page = $_GET['page'];
    else
		$start_page = 1; // Need to determine correct LIMIT

	$goods_qty = mysql_result(exec_query("SELECT COUNT(*) FROM ksh_shop_goods WHERE category='".$id."' AND (`if_hide` IS NULL OR `if_hide` != '1')"), 0, 0);
    debug ("goods qty: ".$goods_qty);
    $pages_qty = ceil($goods_qty / $goods_on_page);
    debug ("pages qty: ".$pages_qty);

	if (0 != $goods_qty)
		if ("yes" == $config['shop']['show_multiple_add_form'])
			$content['show_multiple_add_form'] = "yes";
		else
			$content['show_multiple_add_form'] = "";
    else
		$content['content'] = "";

	$result = exec_query("SELECT * FROM ksh_shop_goods WHERE category='".mysql_real_escape_string($id)."' AND (`if_hide` IS NULL OR `if_hide` != '1') ORDER BY ".mysql_real_escape_string($config['shop']['categories_goods_sort_by'])." ".mysql_real_escape_string($config['shop']['categories_goods_sort_order'])." LIMIT ".mysql_real_escape_string(($start_page - 1) * $goods_on_page).",".$goods_on_page);

	$i = 0;
    while ($good = mysql_fetch_array($result))
    {
		$content['goods_by_category'][$i]['author'] = stripslashes($good['author']);
		$content['goods_by_category'][$i]['author_name'] = stripslashes(mysql_result(exec_query("SELECT name FROM ksh_shop_authors WHERE id='".$good['author']."'"),0,0));
		$content['goods_by_category'][$i]['id'] = stripslashes($good['id']);
		$content['goods_by_category'][$i]['name'] = stripslashes($good['name']);
		$content['goods_by_category'][$i]['image'] = stripslashes($good['image']);
		$content['goods_by_category'][$i]['new_qty'] = stripslashes($good['new_qty']);
		$content['goods_by_category'][$i]['new_price'] = stripslashes($good['new_price']);

		if ("1" == $good['if_new'])
			$content['goods_by_category'][$i]['is_new'] = "yes";
		else
			$content['goods_by_category'][$i]['is_new'] = "";
		
		if ("1" == $good['if_popular'])
			$content['goods_by_category'][$i]['is_popular'] = "yes";
		else
			$content['goods_by_category'][$i]['is_popular'] = "";
			
        if ("" != $good['new_qty'] && 0 != $good['new_qty'])
		{
			$content['goods_by_category'][$i]['show_request_link'] = "";
			$content['goods_by_category'][$i]['presence'] = "";
		}
		else
		{
			$content['goods_by_category'][$i]['presence'] = "Нет в наличии";
			$content['goods_by_category'][$i]['show_request_link'] = "yes";
		}

		if (1 == $user['id'])
		{
			$content['goods_by_category'][$i]['show_edit_link'] = "yes";
			$content['goods_by_category'][$i]['show_del_link'] = "yes";
		}
		$i++;
    }

    mysql_free_result($result);


    // Pages counting

    if ($pages_qty > 1)
    {
        for ($i = 1; $i <= $pages_qty; $i++)
        {
            if ((!isset($_GET['page']) && ($i == 1)) || ($i == $_GET['page']))
                $content['pages'] .= " | ".$i;
            else
                $content['pages'] .= " | <a href=\"/index.php?module=shop&action=view_by_categories&categories=".$id."&page=".$i."\">".$i."</a>";
        }
    }
	else
		$content['pages'] = "| 1 ";
    // End: Pages counting


	debug ("*** end:shop_view_by_categories ***");
	return $content;
}

function shop_view_by_authors($id = 0)
{
	debug ("*** shop_view_by_authors ***");
	global $user;
	global $config;
	$content = array(
		'result' => '',
		'content' => '',
		'author_name' => '',
		'author_id' => '',
		'show_multiple_add_form' => '',
		'show_admin_link' => '',
		'show_add_link' => '',
		'pages' => '',
		'goods_by_author' => ''
	);

	if (1 == $user['id'])
	{
		debug ("user is admin");
		$content['show_admin_link'] = "yes";
		$content['show_add_link'] = "yes";
	}
	else
		debug ("user isn't admin");

	if (!$id)
	{
		if (isset($_GET['authors']))
			$id = $_GET['authors'];
		else if (isset($_POST['authors']))
			$id = $_POST['authors'];
	}

	$content['author_id'] = $id;
	$sql_query = "SELECT * FROM `ksh_shop_authors` WHERE `id` = '".$id."'";
	$result = exec_query($sql_query);
	$row_author = mysql_fetch_array($result);
	mysql_free_result($result);

	$content['author_name'] = stripslashes($row_author['name']);
	$content['author_image'] = stripslashes($row_author['image']);
	$content['author_descr'] = stripslashes($row_author['descr']);

	$goods_on_page = $config['shop']['goods_on_page'];

	if ((isset($_GET['page'])) && ($_GET['page'] > 1))
		$start_page = $_GET['page'];
    else
		$start_page = 1; // Need to determine correct LIMIT

	$goods_qty = mysql_result(exec_query("SELECT COUNT(*) FROM ksh_shop_goods WHERE author='".$id."'"), 0, 0);
    debug ("goods qty: ".$goods_qty);
    $pages_qty = ceil($goods_qty / $goods_on_page);
    debug ("pages qty: ".$pages_qty);

	if (0 != $goods_qty)
		if ("yes" == $config['shop']['show_multiple_add_form'])
			$content['show_multiple_add_form'] = "yes";
		else
			$content['show_multiple_add_form'] = "";
    else
		$content['content'] = "Извините, товаров этого автора пока нет, следите за обновлениями.";

	$result = exec_query("SELECT * FROM ksh_shop_goods WHERE
		author='".mysql_real_escape_string($id)."'
		ORDER BY ".mysql_real_escape_string($config['shop']['categories_goods_sort_by'])."
		".mysql_real_escape_string($config['shop']['categories_goods_sort_order'])."
		LIMIT ".mysql_real_escape_string(($start_page - 1) * $goods_on_page).",".$goods_on_page);

	$i = 0;
    while ($good = mysql_fetch_array($result))
    {
		$content['goods_by_author'][$i]['category'] = stripslashes($good['category']);
		$content['goods_by_author'][$i]['category_name'] = stripslashes(mysql_result(exec_query("SELECT name FROM ksh_shop_categories WHERE id='".$good['category']."'"),0,0));
		$content['goods_by_author'][$i]['id'] = stripslashes($good['id']);
		$content['goods_by_author'][$i]['name'] = stripslashes($good['name']);
		$content['goods_by_author'][$i]['image'] = stripslashes($good['image']);
		$content['goods_by_author'][$i]['new_qty'] = stripslashes($good['new_qty']);
		$content['goods_by_author'][$i]['new_price'] = stripslashes($good['new_price']);
		
		if ("1" == $good['if_new'])
			$content['goods_by_author'][$i]['is_new'] = "yes";
		else
			$content['goods_by_author'][$i]['is_new'] = "";
		
		if ("1" == $good['if_popular'])
			$content['goods_by_author'][$i]['is_popular'] = "yes";
		else
			$content['goods_by_author'][$i]['is_popular'] = "";

        if ("" != $good['new_qty'] && 0 != $good['new_qty'])
		{
			$content['goods_by_author'][$i]['presence'] = "";
			$content['goods_by_author'][$i]['show_request_link'] = "";
		}
		else
		{
			$content['goods_by_author'][$i]['presence'] = "Нет в наличии";
			$content['goods_by_author'][$i]['show_request_link'] = "yes";
		}
		$i++;
    }

    mysql_free_result($result);


    // Pages counting

    if ($pages_qty > 1)
    {
        for ($i = 1; $i <= $pages_qty; $i++)
        {
            if ((!isset($_GET['page']) && ($i == 1)) || ($i == $_GET['page']))
                $content['pages'] .= " | ".$i;
            else
                $content['pages'] .= " | <a href=\"/index.php?module=shop&action=view_by_authors&authors=".$id."&page=".$i."\">".$i."</a>";
        }
    }
	else
		$content['pages'] = "| 1 ";
    // End: Pages counting

	$tpl = new Templater();
	$content['goods_by_author'] = $tpl->colonize($content['goods_by_author'], $config['shop']['lastitems']);

	debug ("*** end:shop_view_by_authors ***");
	return $content;
}

function shop_view_by_tag()
{
	debug ("*** shop_view_by_tag ***");
	global $user;
	global $config;
	$content = array(
		'result' => '',
		'content' => '',
		'show_admin_link' => '',
		'pages' => '',
		'goods_by_tag' => ''
	);

	if (1 == $user['id'])
	{
		debug ("user is admin");
		$content['show_admin_link'] = "yes";
		$content['show_add_link'] = "yes";
	}
	else
		debug ("user isn't admin");

	if (isset($_GET['element']))
		$tag = $_GET['element'];
	else if (isset($_GET['tag']))
		$tag = $_GET['tag'];
	else
		$tag = "";
	
	$content['tag'] = $tag;

	$goods_on_page = $config['shop']['goods_on_page'];

	if ((isset($_GET['page'])) && ($_GET['page'] > 1))
		$start_page = $_GET['page'];
    else
		$start_page = 1; // Need to determine correct LIMIT

	$goods_qty = mysql_result(exec_query("SELECT COUNT(*) FROM ksh_shop_goods WHERE `tags` LIKE '%".mysql_real_escape_string($tag)."%'"), 0, 0);
    debug ("goods qty: ".$goods_qty);
    $pages_qty = ceil($goods_qty / $goods_on_page);
    debug ("pages qty: ".$pages_qty);

	if (0 != $goods_qty)
		if ("yes" == $config['shop']['show_multiple_add_form'])
			$content['show_multiple_add_form'] = "yes";
		else
			$content['show_multiple_add_form'] = "";
    else
		$content['content'] = "Извините, товаров по этой метке пока нет, следите за обновлениями.";

	$result = exec_query("SELECT * FROM `ksh_shop_goods` WHERE `tags` LIKE '%".mysql_real_escape_string($tag)."%'
		ORDER BY ".mysql_real_escape_string($config['shop']['categories_goods_sort_by'])."
		".mysql_real_escape_string($config['shop']['categories_goods_sort_order'])."
		LIMIT ".mysql_real_escape_string(($start_page - 1) * $goods_on_page).",".$goods_on_page
		);

	$i = 0;
    while ($good = mysql_fetch_array($result))
    {
		$content['goods_by_tag'][$i]['category'] = stripslashes($good['category']);
		$content['goods_by_tag'][$i]['category_name'] = stripslashes(mysql_result(exec_query("SELECT `name` FROM `ksh_shop_categories` WHERE id='".$good['category']."'"),0,0));
		$content['goods_by_tag'][$i]['id'] = stripslashes($good['id']);
		$content['goods_by_tag'][$i]['name'] = stripslashes($good['name']);
		$content['goods_by_tag'][$i]['image'] = stripslashes($good['image']);
		$content['goods_by_tag'][$i]['new_qty'] = stripslashes($good['new_qty']);
		$content['goods_by_tag'][$i]['new_price'] = stripslashes($good['new_price']);
		
		if ("1" == $good['if_new'])
			$content['goods_by_tag'][$i]['is_new'] = "yes";
		else
			$content['goods_by_tag'][$i]['is_new'] = "";
		
		if ("1" == $good['if_popular'])
			$content['goods_by_tag'][$i]['is_popular'] = "yes";
		else
			$content['goods_by_tag'][$i]['is_popular'] = "";

        if ("" != $good['new_qty'] && 0 != $good['new_qty'])
		{
			$content['goods_by_tag'][$i]['presence'] = "";
			$content['goods_by_tag'][$i]['show_request_link'] = "";
		}
		else
		{
			$content['goods_by_tag'][$i]['presence'] = "Нет в наличии";
			$content['goods_by_tag'][$i]['show_request_link'] = "yes";
		}
		$i++;
    }

    mysql_free_result($result);


    // Pages counting

    if ($pages_qty > 1)
    {
        for ($i = 1; $i <= $pages_qty; $i++)
        {
            if ((!isset($_GET['page']) && ($i == 1)) || ($i == $_GET['page']))
                $content['pages'] .= " | ".$i;
            else
                $content['pages'] .= " | <a href=\"/shop/view_by_tag/".$tag."/page:".$i."\">".$i."</a>";
        }
    }
	else
		$content['pages'] = "| 1 ";
    // End: Pages counting


	debug ("*** end:shop_view_by_tag ***");
	return $content;
}


function shop_view_popular()
{
	debug ("*** shop_view_popular ***");
	global $user;
	global $config;
	$content = array(
		'result' => '',
		'content' => '',
		'category_name' => '',
		'category_id' => '',
		'show_multiple_add_form' => '',
		'show_admin_link' => '',
		'show_add_link' => '',
		'pages' => '',
		'goods_by_category' => ''
	);

	if (1 == $user['id'])
	{
		debug ("user is admin");
		$content['show_admin_link'] = "yes";
		$content['show_add_link'] = "yes";
	}
	else
		debug ("user isn't admin");


	$goods_on_page = $config['shop']['goods_on_page'];

	if ((isset($_GET['page'])) && ($_GET['page'] > 1))
		$start_page = $_GET['page'];
    else
		$start_page = 1; // Need to determine correct LIMIT

	$goods_qty = mysql_result(exec_query("SELECT COUNT(*) FROM ksh_shop_goods WHERE if_popular='1'"), 0, 0);
    debug ("goods qty: ".$goods_qty);
    $pages_qty = ceil($goods_qty / $goods_on_page);
    debug ("pages qty: ".$pages_qty);

	if (0 != $goods_qty)
		if ("yes" == $config['shop']['show_multiple_add_form'])
			$content['show_multiple_add_form'] = "yes";
		else
			$content['show_multiple_add_form'] = "";
    else
		$content['content'] = "Извините, в этой категории товаров пока нет, следите за обновлениями.";

	$result = exec_query("SELECT * FROM ksh_shop_goods WHERE if_popular='1' ORDER BY ".mysql_real_escape_string($config['shop']['popular_goods_sort_by'])." ".mysql_real_escape_string($config['shop']['popular_goods_sort_order'])." LIMIT ".mysql_real_escape_string(($start_page - 1) * $goods_on_page).",".$goods_on_page);

	$i = 0;
    while ($good = mysql_fetch_array($result))
    {
		$content['goods_popular'][$i]['author'] = stripslashes($good['author']);
		$content['goods_popular'][$i]['author_name'] = stripslashes(mysql_result(exec_query("SELECT name FROM ksh_shop_authors WHERE id='".$good['author']."'"),0,0));
		$content['goods_popular'][$i]['category'] = stripslashes($good['category']);
		$content['goods_popular'][$i]['category_name'] = stripslashes(mysql_result(exec_query("SELECT name FROM ksh_shop_categories WHERE id='".$good['category']."'"),0,0));
		$content['goods_popular'][$i]['id'] = stripslashes($good['id']);
		$content['goods_popular'][$i]['name'] = stripslashes($good['name']);
		$content['goods_popular'][$i]['image'] = stripslashes($good['image']);
		$content['goods_popular'][$i]['new_qty'] = stripslashes($good['new_qty']);
		$content['goods_popular'][$i]['new_price'] = stripslashes($good['new_price']);

		if ("1" == $good['if_new'])
			$content['goods_popular'][$i]['is_new'] = "yes";
		else
			$content['goods_popular'][$i]['is_new'] = "";
		
		if ("1" == $good['if_popular'])
			$content['goods_popular'][$i]['is_popular'] = "yes";
		else
			$content['goods_popular'][$i]['is_popular'] = "";
			
        if ("" != $good['new_qty'] && 0 != $good['new_qty'])
		{
			$content['goods_popular'][$i]['show_request_link'] = "";
			$content['goods_popular'][$i]['presence'] = "";
		}
		else
		{
			$content['goods_popular'][$i]['presence'] = "Нет в наличии";
			$content['goods_popular'][$i]['show_request_link'] = "yes";
		}
		$i++;
    }

    mysql_free_result($result);

	$tpl = new Templater();
	$content['goods_popular'] = $tpl->colonize($content['goods_popular'], $config['shop']['lastitems']);

    // Pages counting

    if ($pages_qty > 1)
    {
        for ($i = 1; $i <= $pages_qty; $i++)
        {
            if ((!isset($_GET['page']) && ($i == 1)) || ($i == $_GET['page']))
                $content['pages'] .= " | ".$i;
            else
                $content['pages'] .= " | <a href=\"/index.php?module=shop&action=view_popular&page=".$i."\">".$i."</a>";
        }
    }
	else
		$content['pages'] = "| 1 ";
    // End: Pages counting


	debug ("*** end:shop_view_popular ***");
	return $content;
}

function shop_view_new()
{
	debug ("*** shop_view_new ***");
	global $user;
	global $config;
	$content = array(
		'result' => '',
		'content' => '',
		'category_name' => '',
		'category_id' => '',
		'show_multiple_add_form' => '',
		'show_admin_link' => '',
		'show_add_link' => '',
		'pages' => '',
		'goods_by_category' => ''
	);

	if (1 == $user['id'])
	{
		debug ("user is admin");
		$content['show_admin_link'] = "yes";
		$content['show_add_link'] = "yes";
	}
	else
		debug ("user isn't admin");


	$goods_on_page = $config['shop']['goods_on_page'];

	if ((isset($_GET['page'])) && ($_GET['page'] > 1))
		$start_page = $_GET['page'];
    else
		$start_page = 1; // Need to determine correct LIMIT

	$goods_qty = mysql_result(exec_query("SELECT COUNT(*) FROM ksh_shop_goods WHERE if_new='1'"), 0, 0);
    debug ("goods qty: ".$goods_qty);
    $pages_qty = ceil($goods_qty / $goods_on_page);
    debug ("pages qty: ".$pages_qty);

	if (0 != $goods_qty)
		if ("yes" == $config['shop']['show_multiple_add_form'])
			$content['show_multiple_add_form'] = "yes";
		else
			$content['show_multiple_add_form'] = "";
    else
		$content['content'] = "Извините, в этой категории товаров пока нет, следите за обновлениями.";

	$result = exec_query("SELECT * FROM ksh_shop_goods WHERE if_new='1' ORDER BY ".mysql_real_escape_string($config['shop']['new_goods_sort_by'])." ".mysql_real_escape_string($config['shop']['new_goods_sort_order'])." LIMIT ".mysql_real_escape_string(($start_page - 1) * $goods_on_page).",".$goods_on_page);

	$i = 0;
    while ($good = mysql_fetch_array($result))
    {
		$content['goods_new'][$i]['author'] = stripslashes($good['author']);
		$content['goods_new'][$i]['author_name'] = stripslashes(mysql_result(exec_query("SELECT name FROM ksh_shop_authors WHERE id='".$good['author']."'"),0,0));
		$content['goods_new'][$i]['category'] = stripslashes($good['category']);
		$content['goods_new'][$i]['category_name'] = stripslashes(mysql_result(exec_query("SELECT name FROM ksh_shop_categories WHERE id='".$good['category']."'"),0,0));
		$content['goods_new'][$i]['id'] = stripslashes($good['id']);
		$content['goods_new'][$i]['name'] = stripslashes($good['name']);
		$content['goods_new'][$i]['image'] = stripslashes($good['image']);
		$content['goods_new'][$i]['new_qty'] = stripslashes($good['new_qty']);
		$content['goods_new'][$i]['new_price'] = stripslashes($good['new_price']);

		if ("1" == $good['if_new'])
			$content['goods_new'][$i]['is_new'] = "yes";
		else
			$content['goods_new'][$i]['is_new'] = "";
		
		if ("1" == $good['if_new'])
			$content['goods_new'][$i]['is_new'] = "yes";
		else
			$content['goods_new'][$i]['is_new'] = "";
			
        if ("" != $good['new_qty'] && 0 != $good['new_qty'])
		{
			$content['goods_new'][$i]['show_request_link'] = "";
			$content['goods_new'][$i]['presence'] = "";
		}
		else
		{
			$content['goods_new'][$i]['presence'] = "Нет в наличии";
			$content['goods_new'][$i]['show_request_link'] = "yes";
		}
		$i++;
    }

    mysql_free_result($result);

	$tpl = new Templater();
	$content['goods_new'] = $tpl->colonize($content['goods_new'], $config['shop']['lastitems']);

    // Pages counting

    if ($pages_qty > 1)
    {
        for ($i = 1; $i <= $pages_qty; $i++)
        {
            if ((!isset($_GET['page']) && ($i == 1)) || ($i == $_GET['page']))
                $content['pages'] .= " | ".$i;
            else
                $content['pages'] .= " | <a href=\"/index.php?module=shop&action=view_new&page=".$i."\">".$i."</a>";
        }
    }
	else
		$content['pages'] = "| 1 ";
    // End: Pages counting


	debug ("*** end:shop_view_new ***");
	return $content;
}

function shop_view_recommended()
{
	debug ("*** shop_view_recommended ***");
	global $user;
	global $config;
	$content = array(
		'result' => '',
		'content' => '',
		'category_name' => '',
		'category_id' => '',
		'show_multiple_add_form' => '',
		'show_admin_link' => '',
		'show_add_link' => '',
		'pages' => '',
		'goods_by_category' => ''
	);

	if (1 == $user['id'])
	{
		debug ("user is admin");
		$content['show_admin_link'] = "yes";
		$content['show_add_link'] = "yes";
	}
	else
		debug ("user isn't admin");


	$goods_on_page = $config['shop']['goods_on_page'];

	if ((isset($_GET['page'])) && ($_GET['page'] > 1))
		$start_page = $_GET['page'];
    else
		$start_page = 1; // Need to determine correct LIMIT

	$goods_qty = mysql_result(exec_query("SELECT COUNT(*) FROM ksh_shop_goods WHERE `if_recommended` = '1'"), 0, 0);
    debug ("goods qty: ".$goods_qty);
    $pages_qty = ceil($goods_qty / $goods_on_page);
    debug ("pages qty: ".$pages_qty);

	if (0 != $goods_qty)
		if ("yes" == $config['shop']['show_multiple_add_form'])
			$content['show_multiple_add_form'] = "yes";
		else
			$content['show_multiple_add_form'] = "";
    else
		$content['content'] = "Извините, в этой категории товаров пока нет, следите за обновлениями.";

	$result = exec_query("SELECT * FROM ksh_shop_goods
		WHERE `if_recommended` = '1'
		ORDER BY `".mysql_real_escape_string($config['shop']['recommended_goods_sort_by'])."`
		".mysql_real_escape_string($config['shop']['recommended_goods_sort_order'])."
		LIMIT ".mysql_real_escape_string(($start_page - 1) * $goods_on_page).",".$goods_on_page);

	$i = 0;
    while ($good = mysql_fetch_array($result))
    {
		$content['goods_recommended'][$i]['author'] = stripslashes($good['author']);
		$content['goods_recommended'][$i]['author_name'] = stripslashes(mysql_result(exec_query("SELECT name FROM ksh_shop_authors WHERE id='".$good['author']."'"),0,0));
		$content['goods_recommended'][$i]['category'] = stripslashes($good['category']);
		$content['goods_recommended'][$i]['category_name'] = stripslashes(mysql_result(exec_query("SELECT name FROM ksh_shop_categories WHERE id='".$good['category']."'"),0,0));
		$content['goods_recommended'][$i]['id'] = stripslashes($good['id']);
		$content['goods_recommended'][$i]['name'] = stripslashes($good['name']);
		$content['goods_recommended'][$i]['image'] = stripslashes($good['image']);
		$content['goods_recommended'][$i]['new_qty'] = stripslashes($good['new_qty']);
		$content['goods_recommended'][$i]['new_price'] = stripslashes($good['new_price']);

		if ("1" == $good['if_new'])
			$content['goods_recommended'][$i]['is_new'] = "yes";
		else
			$content['goods_recommended'][$i]['is_new'] = "";
		
		if ("1" == $good['if_popular'])
			$content['goods_recommended'][$i]['is_popular'] = "yes";
		else
			$content['goods_recommended'][$i]['is_popular'] = "";
			
        if ("" != $good['new_qty'] && 0 != $good['new_qty'])
		{
			$content['goods_recommended'][$i]['show_request_link'] = "";
			$content['goods_recommended'][$i]['presence'] = "";
		}
		else
		{
			$content['goods_recommended'][$i]['presence'] = "Нет в наличии";
			$content['goods_recommended'][$i]['show_request_link'] = "yes";
		}
		$i++;
    }

    mysql_free_result($result);

	$tpl = new Templater();
	$content['goods_recommended'] = $tpl->colonize($content['goods_recommended'], $config['shop']['lastitems']);

    // Pages counting

    if ($pages_qty > 1)
    {
        for ($i = 1; $i <= $pages_qty; $i++)
        {
            if ((!isset($_GET['page']) && ($i == 1)) || ($i == $_GET['page']))
                $content['pages'] .= " | ".$i;
            else
                $content['pages'] .= " | <a href=\"/index.php?module=shop&action=view_new&page=".$i."\">".$i."</a>";
        }
    }
	else
		$content['pages'] = "| 1 ";
    // End: Pages counting


	debug ("*** end:shop_view_recommeded ***");
	return $content;
}


function shop_view_good()
{
	debug ("*** shop_view_good ***");
	global $user;
	global $config;
	$content = array(
		'result' => '',
		'content' => '',
		'name' => '',
		'image' => '',
		'publisher' => '',
		'year' => '',
		'genre' => '',
		'original_name' => '',
		'format' => '',
		'pages_qty' => '',
		'commentary' => '',
		'images' => '',
		'show_order_form' => '',
		'show_query_form' => '',
		'new_price' => '',
		'qty_select' => '',
		'show_admin_link' => '',
		'pdf' => '',
		'epub' => '',
		'mp3' => '',
		'embed' => '',
		'tags' => ''
	);

	global $home; // to determine files' size

	if (1 == $user['id'])
	{
		debug ("user is admin");
		$content['show_admin_link'] = "yes";
	}
	else
		debug ("user isn't admin");

	if (isset($_GET['good'])) $id = $_GET['good'];
	else $id = 0;

	$config['modules']['current_id'] = $id;

	$result = exec_query("SELECT * FROM ksh_shop_goods WHERE id='".mysql_real_escape_string($id)."'");
	$good = mysql_fetch_array($result);
    mysql_free_result($result);

	$content['category'] = stripslashes($good['category']);
	$config['modules']['current_category'] = $content['category'];

	$content['category_name'] = mysql_result(exec_query("SELECT name FROM ksh_shop_categories WHERE id='".$good['category']."'"),0,0);
	$content['author'] = stripslashes($good['author']);
    $content['author_name'] = mysql_result(exec_query("SELECT name FROM ksh_shop_authors WHERE id='".$good['author']."'"),0,0);

	$content['id'] = stripslashes($good['id']);
	$content['name'] = stripslashes($good['name']);
	$content['image'] = stripslashes($good['image']);
	$content['publisher'] = stripslashes($good['publisher']);
	$content['year'] = stripslashes($good['year']);
	$content['genre'] = stripslashes($good['genre']);
	$content['original_name'] = stripslashes($good['original_name']);
	$content['format'] = stripslashes($good['format']);
	$content['language'] = stripslashes($good['language']);
	$content['pages_qty'] = stripslashes($good['pages_qty']);
	$content['commentary'] = stripslashes($good['commentary']);
	$content['images'] = stripslashes($good['images']);
	$content['new_price'] = stripslashes($good['new_price']);
	$content['pdf'] = stripslashes($good['pdf']);
	$content['epub'] = stripslashes($good['epub']);
	$content['mp3'] = stripslashes($good['mp3']);
	$content['embed'] = stripslashes($good['embed']);

	$content['links'] = shop_goods_links_extract(stripslashes($good['links']));

	$tags_list = stripslashes($good['tags']);
	if ("" != $tags_list && " " != $tags_list)
	{
		$tags = explode(",", $tags_list);
		foreach($tags as $k => $v)
		{
			if ("" != $v && " " != $v)
			{
				$content['tags'][$k]['tag'] = trim($v);
				$content['tags'][$k]['url'] = urlencode($content['tags'][$k]['tag']);
				$content['tags'][$k]['not_last'] = "yes";
			}
		}
		$content['tags'][$k]['not_last'] = "";
	}

	if ("" != $content['pdf'])
		$content['pdf_size'] = format_bytes(filesize($home.$content['pdf']));

	if ("" != $content['epub'])
		$content['epub_size'] = format_bytes(filesize($home.$content['epub']));


	if ("" != $content['mp3'])
		$content['mp3_size'] = format_bytes(filesize($home.$content['mp3']));

	$image_path = $config['base']['doc_root'].$content['images'];
	if ("" != $content['images'] && file_exists($image_path))
		list($content['images_width'],$content['images_height']) = getimagesize($image_path);
	else
	{
		$content['images_width'] = "";
		$content['images_height'] = "";
	}

	for ($i = 1; $i <= $good['new_qty']; $i++)
	{
		$content['qty_select'] .= "<option value=\"".$i."\"";
		if (1 == $i) $content['qty_select'] .= " selected";
		$content['qty_select'] .= ">".$i."</option>";
	}


	if (("0" == $good['new_qty']) || ("" == $good['new_qty']))
		$content['show_query_form'] = "yes";
	else
		$content['show_order_form'] = "yes";

	$sql_query = "SELECT `image` FROM `ksh_shop_authors` WHERE `id` = '".mysql_real_escape_string($content['author'])."'";
	$result = exec_query($sql_query);
	$row = mysql_fetch_array($result);
	mysql_free_result($result);
	$content['author_image'] = stripslashes($row['image']);

	$content['goods_by_author_row'] = array();
	$i = 0;
	$sql_query = "SELECT * FROM `ksh_shop_goods` WHERE `author` = '".mysql_real_escape_string($content['author'])."' ORDER BY `id` DESC";
	$result = exec_query($sql_query);
	while ($row = mysql_fetch_array($result))
	{
		$content['goods_by_author_row'][$i]['id'] = stripslashes($row['id']);
		$content['goods_by_author_row'][$i]['image'] = stripslashes($row['image']);
		$content['goods_by_author_row'][$i]['name'] = stripslashes($row['name']);
		$i++;
	}
	mysql_free_result($result);

	$tpl = new Templater();
	$content['goods_by_author_row'] = $tpl->colonize($content['goods_by_author_row'], $config['shop']['lastitems']);
	debug("goods_by_author_row", 3);
	dump($content['goods_by_author_row']);

	debug ("*** end:shop_view_good ***");
	return $content;
}

/* Old functions */

function shop_view_last($category = 0, $mode = "category")
{
	global $config;
	debug ("*** shop_view_last ***");

	$content = array(
		'result' => '',
		'content' => '',
		'category_name' => '',
		'category_id' => '',
		'show_multiple_add_form' => '',
		'show_admin_link' => '',
		'show_add_link' => '',
		'goods_by_category' => ''
	);

	if (1 == $user['id'])
	{
		debug ("user is admin");
		$content['show_admin_link'] = "yes";
		$content['show_add_link'] = "yes";
	}
	else
		debug ("user isn't admin");

	if ($category)
		$id = $category;
	else if (isset($_GET['categories']))
		$id = $_GET['categories'];
	else
		$id = 0;

	if ($id)
	{
		if ("category" == $mode)
		{
			$content['category_id'] = $id;
			$content['category_name'] = mysql_result(exec_query("SELECT `name` FROM `ksh_shop_categories` WHERE `id` = '".mysql_real_escape_string($id)."'"),0,0);
		}
		else  if ("author" == $mode)
		{
			$content['category_id'] = $id;
			$content['category_name'] = mysql_result(exec_query("SELECT `name` FROM `ksh_shop_authors` WHERE `id` = '".mysql_real_escape_string($id)."'"),0,0);
		}

		$last_goods_qty = $config['shop']['lastitems'];

		$goods_qty = mysql_result(exec_query("SELECT COUNT(*) FROM `ksh_shop_goods` WHERE `".mysql_real_escape_string($mode)."` = '".mysql_real_escape_string($id)."'"), 0, 0);
	    debug ("goods qty: ".$goods_qty);

		if (0 != $goods_qty)
		{
			if ("yes" == $config['shop']['show_multiple_add_form'])
				$content['show_multiple_add_form'] = "yes";
			else
				$content['show_multiple_add_form'] = "";
		}
	    else
			$content['content'] = "Извините, в этой категории товаров пока нет, следите за обновлениями.";

		$result = exec_query("SELECT * FROM `ksh_shop_goods` WHERE `".mysql_real_escape_string($mode)."` = '".mysql_real_escape_string($id)."' ORDER BY `id` DESC LIMIT ".mysql_real_escape_string($last_goods_qty));

		$i = 0;
    	while ($good = mysql_fetch_array($result))
    	{
			$content['goods_by_category'][$i]['author'] = stripslashes($good['author']);
			$content['goods_by_category'][$i]['author_name'] = stripslashes(mysql_result(exec_query("SELECT `name` FROM `ksh_shop_authors` WHERE `id` = '".$good['author']."'"),0,0));
			$content['goods_by_category'][$i]['id'] = stripslashes($good['id']);
			$content['goods_by_category'][$i]['name'] = stripslashes($good['name']);
			$content['goods_by_category'][$i]['image'] = stripslashes($good['image']);
			$content['goods_by_category'][$i]['new_qty'] = stripslashes($good['new_qty']);
			$content['goods_by_category'][$i]['new_price'] = stripslashes($good['new_price']);

        	if ("" != $good['new_qty'] && 0 != $good['new_qty'])
				$content['goods_by_category'][$i]['presence'] = "";
			else
				$content['goods_by_category'][$i]['presence'] = "Нет в наличии";
			$i++;
    	}

    	mysql_free_result($result);
	}
	else
	{
		$content['content'] .= "Не указана категория";
	}


    debug ("*** end: shop_view_last");
    return $content;
}

function shop_goods_view_hidden()
{
	debug ("*** shop_goods_view_hidden ***");
	global $user;
	global $config;
	$content = array(
		'result' => '',
		'content' => '',
		'all_goods' => '',
		'show_admin_link' => '',
		'show_add_link' => ''
	);
	if (1 == $user['id'])
	{
		debug ("user is admin");
		$content['show_admin_link'] = "yes";
		$content['show_add_link'] = "yes";

		if (isset($_POST['do_del']))
		{
			debug ("user is admin, deleting from DB");
			exec_query ("delete from ksh_shop_goods where id='".mysql_real_escape_string($_POST['id'])."'");
			$content['result'] = "Товар удалён";
		}

	    $sql_query =  "SELECT `id`,`name`,`author`,`category` FROM `ksh_shop_goods` WHERE `if_hide` = '1' ORDER BY `id`";
		$result = exec_query($sql_query);
		$i = 0;
	    while ($good = mysql_fetch_array($result))
	    {
	        $content['all_goods'][$i]['id'] = stripslashes($good['id']);
	        $content['all_goods'][$i]['name'] = stripslashes($good['name']);
	        $content['all_goods'][$i]['author'] = stripslashes($good['author']);
	        $content['all_goods'][$i]['category'] = stripslashes($good['category']);
	        $content['all_goods'][$i]['category_name'] = mysql_result(exec_query("SELECT `name` FROM `ksh_shop_categories` WHERE `id` = '".stripslashes($good['category'])."'"), 0, 0);
	        $i++;
	    }
	    mysql_free_result($result);

		foreach ($content['all_goods'] as $k => $v)
		{
				$content['all_goods'][$k]['show_edit_link'] = "yes";
				$content['all_goods'][$k]['show_del_link'] = "yes";
		}
	}
	else
		debug ("user isn't admin");

	debug ("*** end:shop_goods_view_hidden ***");
	return $content;
}

function shop_goods_links_extract($links_string)
{
	global $user;
	global $config;
	debug("*** shop_goods_links_extract ***");

	$links = array();

	if ("" != $links_string)
	{

		$links_array = explode("|", $links_string);
		debug("links_array:", 2);
		dump($links_array);

		$i = 0;
		$j = 1;
		foreach($links_array as $k => $v)
		{
			debug("i: ".$i.", j: ".$j."; links array element ".$k.": ".$v);
			switch($j)
			{
				default: break;
				case "1":
					$links[$i]['title'] = $v;
				break;
				case "2":
					$links[$i]['img'] = $v;
				break;
				case "3":
					$links[$i]['url'] = $v;
					$links[$i]['id'] = $i;
					$i++;
					$j = 0;
				break;
			}
			$j++;
		}
	}
	debug("links:", 2);
	dump($links);

	debug("*** end: shop_goods_links_extract ***");
	return ($links);
}

?>
