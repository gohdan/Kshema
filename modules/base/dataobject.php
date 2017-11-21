<?php

class DataObject
{

var $table;
var $categories_table;
var $elements_table;
var $elements_on_page;
var $order_field = "date";
var $order_type = "DESC";

function view_by_category($category = 0)
{
	global $config;
	global $user;
	global $template;

	debug ("*** DataObject: view_by_category ***");

	$content = array (
		'show_admin_link' => '',
		'category_title' => '',
		'category_id' => '',
		'elements' => array (),
		'content' => '',
		'result' => '',
		'subcategories' => array(),
		'show_admin_link' => '',
		'category_title' => '',
		'category_id' => '',
		'bills' => '',
		'show_link_on_main' => 'yes',
		'parent_link' => '',
		'category_pages' => '',
		'parents' => '',
		'module_name' => '',
		'action' => ''		
	);

	$cat = new Category();
	$priv = new Privileges();

	if ($priv -> has($config['modules']['current_module'], "admin", "write"))
	{
		debug ("user is admin");
		$content['show_admin_link'] = "yes";
	}

	$categories_table = $this -> categories_table;
	$elements_table = $this -> elements_table;

	$content['module_name'] = $config['modules']['current_module'];
	$content['action'] = "view_by_category";

	$cat = new Category();
	$cat -> table = $categories_table;

	if (!is_numeric($category))
		$category = $cat -> get_id_by_name($category);

	debug ("category: ".$category);

	if ($category)	
	{
		debug("have category id, showing it");
		$content['show_link_on_main'] = "yes";

		// Get category info
		$sql_query = "SELECT * FROM `".db_escape($categories_table)."` WHERE `id` = '".db_escape($category)."'";
		$result = exec_query($sql_query);
		$row = mysqli_fetch_array($result);
		mysqli_free_result($result);
		$content['category_title'] = stripslashes($row['title']);
		$template['title'] .= " - ".$content['category_title'];
		$content['category_id'] = stripslashes($row['id']);

		if (isset($row['parent']) && "" != $row['parent'])
		{
			$parent = stripslashes($row['parent']);

			$sql_query = "SELECT `name` FROM `".db_escape($categories_table)."` WHERE `id` = '".db_escape($parent)."'";
			$result_parent = exec_query($sql_query);
			$row_parent = mysqli_fetch_array($result_parent);
			mysqli_free_result($result_parent);
			$parent_name = stripslashes($row_parent['name']);
			if ("" != $parent_name && NULL != $parent_name)
				$content['parent_link'] = $parent_name;
			else
				$content['parent_link'] = $parent;

			$parents_list = $cat -> get_parents_list($categories_table, $category);
			foreach($parents_list as $k => $v)
				if ($v)
					$config['themes']['page_title']['categories_title'][]['title'] = $cat -> get_title($categories_table, $v);
		}

		$config['themes']['page_title']['element'] = $content['category_title'];		

		// Get pages
		if ((isset($_GET['page'])) && ($_GET['page'] > 1))
		{
			debug("dumping GET", 2);
			dump($_GET);
			debug("GET page is set");
			$start_page = $_GET['page'];
			$content['page'] = $_GET['page'];
		}
	    else
			$start_page = 1; // Need to determine correct LIMIT
		debug("start page: ".$start_page);
		$elements_on_page = $this -> elements_on_page;

		$elements_qty = mysql_result(exec_query("SELECT COUNT(*) FROM `".db_escape($elements_table)."` WHERE `category` = '".$category."'"), 0, 0);
	    debug ("elements qty: ".$elements_qty);
	    $pages_qty = ceil($elements_qty / $elements_on_page);
	    debug ("pages qty: ".$pages_qty);

		// Pages counting

	    if ($pages_qty > 1)
	    {
			debug("building category_pages");
	        for ($i = 1; $i <= $pages_qty; $i++)
	        {
				$content['category_pages'][$i]['id'] = $i;

				$sql_query = "SELECT `name` FROM `".db_escape($categories_table)."` WHERE `id` = '".db_escape($category)."'";
				$result_cat = exec_query($sql_query);
				$row_cat = mysqli_fetch_array($result_cat);
				mysqli_free_result($result_cat);
				$cat_name = stripslashes($row_cat['name']);
				if ("" != $cat_name && NULL != $cat_name)
					$content['category_pages'][$i]['category'] = $cat_name;
				else
					$content['category_pages'][$i]['category'] = $category;

				$content['category_pages'][$i]['category_id'] = $category;

				if ($config['modules']['current_module'] != $config['modules']['default_module'])
				{
					debug("current module isn't default");
					$content['category_pages'][$i]['module'] = "/".$config['modules']['current_module'];
				}
				else
				{
					debug("current module is default");
					$content['category_pages'][$i]['module'] = "";
					$content['category_pages'][$i]['module_name'] = $config['modules']['current_module'];
				}

				if (isset($config[$config['modules']['current_module']]['default_action']) && ("view_by_category" != $config[$config['modules']['current_module']]['default_action']))
				{
					debug("view_by_category isn't default action");
					$content['category_pages'][$i]['action'] = "/view_by_category";
				}
				else
				{
					debug("view_by_category is default action");
					$content['category_pages'][$i]['action'] = "";
					$content['category_pages'][$i]['action_name'] = "view_by_category";
				}

				if (isset($config['base']['inst_root']))
					$content['category_pages'][$i]['inst_root'] = $config['base']['inst_root'];
				if ("" == $content['category_pages'][$i]['module'] && "" == $content['category_pages'][$i]['action'])
					$content['category_pages'][$i]['inst_root'] = rtrim($content['category_pages'][$i]['inst_root'], "/");


				if ((!isset($_GET['page']) && ($i == 1)) || (isset($_GET['page']) && $i == $_GET['page']))
					$content['category_pages'][$i]['show_link'] = "";
	            else
	                $content['category_pages'][$i]['show_link'] = "yes";
	        }
			debug("category_pages:", 2);
			dump($content['category_pages']);
	    }
	    // End: Pages counting



		// Get elements
		debug("getting elements");
		debug("order_field: ".$this -> order_field);
		$sql_query = "SELECT * from `".db_escape($elements_table)."`
			WHERE `category` = '".db_escape($category)."'
			ORDER BY `".db_escape($this -> order_field)."`
			".db_escape($this -> order_type)."
			LIMIT ".db_escape(($start_page - 1) * $elements_on_page).",".$elements_on_page;
		$i = 0;
		$result = exec_query($sql_query);
		while ($row = mysqli_fetch_array($result, MYSQL_ASSOC))
		{
			foreach ($row as $k => $v)
				$row[$k] = stripslashes($v);

			foreach ($row as $k => $v)
				$content['elements'][$i][$k] = $v;

			if (isset($content['elements'][$i]['date']))
				$content['elements'][$i]['date'] = format_date($content['elements'][$i]['date'], $config['base']['lang']['current']);

			if (isset($content['elements'][$i]['name']))
				$content['elements'][$i]['name_urlencoded'] = urlencode($content['elements'][$i]['name']);

			debug("processing element ".$row['id']);

			if ("" == $row['name'])
			{
				debug("empty name, replacing by id");
				$content['elements'][$i]['name'] = $content['elements'][$i]['id'];
			}

			if (!isset($row['descr']) || "" == $row['descr'])
			{
				debug("empty descr, replacing by beginning of full text");

				if (isset($row['full_text_'.$config['base']['lang']['current']]))
					$full_text = $row['full_text_'.$config['base']['lang']['current']];
				else if (isset($row['full_text']))
					$full_text = $row['full_text'];
				else
					$full_text = "";

				if ("" != $full_text)
				{
					$descr = "";
					$sentences = explode(".", strip_tags($full_text));
					for ($j = 0; $j < $config[$config['modules']['current_module']]['descr_sentences']; $j++)
						if (isset($sentences[$j]))
							$descr .= $sentences[$j].". ";
					$descr = rtrim($descr, " ");

					$content['elements'][$i]['descr'] = $descr;
				}
			}


			if ($config['modules']['current_module'] != $config['modules']['default_module'])
			{
				debug("current module isn't default, writing it explicitly");

				if ("" != $config['base']['site_url'] && "" == $config['base']['inst_root'])
					$slash_prepend = "";
				else
					$slash_prepend = "/";

				$content['elements'][$i]['module'] = $slash_prepend.$config['modules']['current_module'];
				$content['elements'][$i]['module_name'] = $slash_prepend.$config['modules']['current_module'];
			}

			if ("yes" == $config['base']['ext_links_redirect'])
			{
				debug("external links redirect is on, replacing links");
				include_once($config['modules']['location']."redirect/index.php");
				$content['elements'][$i]['full_text'] = redirect_links_replace(stripslashes($row['full_text']));
			}
			else
			{
				debug("external links redirect is off");
				if (isset($row['full_text']))
					$content['elements'][$i]['full_text'] = stripslashes($row['full_text']);
			}

			if (isset($config['base']['site_url']))
			{
				debug("site url is set, using it");
				$content['elements'][$i]['site_url'] = $config['base']['site_url'];
			}

			if (isset($config['base']['inst_root']))
			{
				debug("inst_root is set, using it");
				$content['elements'][$i]['inst_root'] = rtrim($config['base']['inst_root'], "/");
			}

			if ($priv -> has($config['modules']['current_module'], "edit", "write") || $priv -> has($config['modules']['current_module'], "del", "write") || ($user['id'] && ($user['id'] == stripslashes($row['user']))))
			{
				debug("user has admin rights, show admin link");
				$content['elements'][$i]['show_admin_link'] = "yes";
			}

			$i++;
		}
		mysqli_free_result($result);
		debug("elements qty: ".count($content['elements']));

	}
	else
		debug("don't have category id, showing top level");

	// Get subcategories
	$i = 0;
	$sql_query = "SELECT * FROM `".db_escape($categories_table)."` WHERE `parent` = '".db_escape($category)."'";
	$result = exec_query($sql_query);
	if ($result && mysql_num_rows($result))
		while ($row = mysqli_fetch_array($result))
		{
			$content['subcategories'][$i]['id'] = stripslashes($row['id']);
			$content['subcategories'][$i]['parent'] = stripslashes($row['parent']);
			$content['subcategories'][$i]['name'] = stripslashes($row['name']);
			$content['subcategories'][$i]['title'] = stripslashes($row['title']);
			if (isset($config['base']['inst_root']))
				$content['subcategories'][$i]['inst_root'] = $config['base']['inst_root'];
			if ($config['modules']['current_module'] != $config['modules']['default_module'])
			{
				$content['subcategories'][$i]['module_name'] = "/".$config['modules']['current_module'];
				$content['subcategories'][$i]['action_name'] = "/view_by_category";
			}
			if ("view_by_category" != $config[$config['modules']['current_module']]['default_action'])
				$content['subcategories'][$i]['action_name'] = "/view_by_category";

			if ("" == $content['subcategories'][$i]['module_name'] && "" == $content['subcategories'][$i]['action_name'])
				$content['subcategories'][$i]['inst_root'] = rtrim($content['subcategories'][$i]['inst_root'], "/");

			if ("" != $content['subcategories'][$i]['name'] && NULL != $content['subcategories'][$i]['name'])
				$content['subcategories'][$i]['category_link'] = $content['subcategories'][$i]['name'];
			else
				$content['subcategories'][$i]['category_link'] = $content['subcategories'][$i]['id'];
			$i++;
		}
	if ($result)
		mysqli_free_result($result);
	debug("subcategories qty: ".count($content['subcategories']));

	// Get parents
	$parents = $cat -> get_parents_list($categories_table, $category);
	debug("parents list:");
	dump($parents);
	$i = 0;
	foreach ($parents as $k => $v)
	{
		if ($v)
		{
			$title = $cat -> get_title($categories_table, $v);
			$name = $cat -> get_name($categories_table, $v);
			if ("" != $name && NULL != $name)
				$id = $name;
			else
				$id = $v;

			$content['parents'][$i]['id'] = $id;
			$content['parents'][$i]['title'] = $title;
			if (isset($config['base']['inst_root']))
				$content['subcategories'][$i]['inst_root'] = $config['base']['inst_root'];
			if ($config['modules']['current_module'] != $config['modules']['default_module'])
				$content['parents'][$i]['module'] = "/".$config['modules']['current_module'];
			else
				$content['parents'][$i]['module'] = "";;
			if ("view_by_category" != $config[$config['modules']['current_module']]['default_action'])
				$content['parents'][$i]['action'] = "/view_by_category";
			else
				$content['parents'][$i]['action'] = "";
			$i++;
		}
	}
	debug("content parents:", 2);
	dump($content['parents']);
	
	

/*
	$sql_query = "SELECT * FROM `".db_escape($categories_table)."` WHERE `id` = '".db_escape($category_id)."'";
	$result = exec_query($sql_query);
	$row = mysqli_fetch_array($result);
	mysqli_free_result($result);

	$content['category_title'] = stripslashes($row['title']);
	$content['category_id'] = $category_id;

	$i = 0;
	$sql_query = "SELECT * FROM `".db_escape($elements_table)."` WHERE `category` = '".db_escape($category_id)."'";
	$result = exec_query($sql_query);
	while ($row = mysqli_fetch_array($result))
	{
		debug ("processing element ".$i);
		$content['elements'][$i]['id'] = stripslashes($row['id']);
		$content['elements'][$i]['name'] = stripslashes($row['name']);
		$content['elements'][$i]['title'] = stripslashes($row['title']);

		if (1 == $user['id'])
		{
			$content['elements'][$i]['show_admin_link'] = "yes";
			$content['elements'][$i]['module_name'] = $config['modules']['current_module'];
		}

		$i++;
	}
	mysqli_free_result($result);
*/
	debug ("=== end: DataObject: view_by_category ***");
	return $content;
}

function generate_unique_name($table, $title)
{
	global $user;
	global $config;
	debug ("*** DataObject: generate_unique_name ***");

	$name = transliterate($title, "ru", "en");
	$i = 0;
	$same_count = 1;
	while ($same_count)
	{
		$i++;
		if ($i > 1)
			$new_name = $name."-".$i;
		else
			$new_name = $name;
		$sql_query = "SELECT COUNT(*) FROM `".db_escape($table)."` WHERE `name` = '".db_escape($new_name)."'";
		$result_count = exec_query($sql_query);
		$row_count = mysqli_fetch_array($result_count);
		mysqli_free_result($result_count);
		$same_count = stripslashes($row_count['COUNT(*)']);
		debug("same names: ".$same_count);
	}
	debug("new name: ".$new_name);

	debug ("*** end: DataObject: generate_unique_name ***");
	return $new_name;
}


function view_by_user($view_user = 0)
{
	global $user;
	global $config;
	debug ("*** DataObject: view_by_user ***");
	$content = array(
		'content' => '',
		'heading' => '',
		'result' => '',
		'elements' => '',
		'page' => '',
		'pages' => '',
		'categories' => '',
		'sections' => '',
		'bbs' => '',
		'show_send_form' => '',
		'all_categories_selected' => '',
		'all_sections_selected' => '',
		'categories_select' => '',
		'sections_select' => ''
	);

	$cat = new Category();

	if($view_user)
		$user_id = $view_user;
	else
		$user_id = $user['id'];

	debug ("user id: ".$user_id);

	if (isset($_POST['categories']))
		$post_categories = $_POST['categories'];
	else
		$post_categories = array();

	if (isset($_POST['sections']))
		$post_sections = $_POST['sections'];
	else
		$post_sections = array();

	// Get pages
	if ((isset($_GET['page'])) && ($_GET['page'] > 1))
	{
		$start_page = $_GET['page'];
		$content['page'] = $_GET['page'];
	}
    else
		$start_page = 1; // Need to determine correct LIMIT

	$elements_qty = mysql_result(exec_query("SELECT COUNT(*) FROM `".db_escape($this -> table)."`
		WHERE `user` = '".db_escape($user_id)."'"), 0, 0);
    debug ("elements qty: ".$elements_qty);
    $pages_qty = ceil($elements_qty / $this -> elements_on_page);
    debug ("pages qty: ".$pages_qty);

	// Pages counting

    if ($pages_qty > 1)
    {
        for ($i = 1; $i <= $pages_qty; $i++)
        {
			$content['pages'][$i]['id'] = $i;
			if ((!isset($_GET['page']) && ($i == 1)) || (isset($_GET['page']) && $i == $_GET['page']))
				$content['pages'][$i]['show_link'] = "";
            else
                $content['pages'][$i]['show_link'] = "yes";
        }
    }
    // End: Pages counting
	

	// Get elements 
	$sql_query = "SELECT * from `".db_escape($this -> table)."`
		WHERE `user` = '".db_escape($user_id)."'
		ORDER BY `".db_escape($this -> order_field)."` ".db_escape($this -> order_type)."
		LIMIT ".db_escape(($start_page - 1) * $this -> elements_on_page).",".$this -> elements_on_page;
	$i = 0;
	$result = exec_query($sql_query);
	while ($row = mysqli_fetch_array($result))
	{
		$content['elements'][$i]['module_name'] = $config['modules']['current_module'];

		foreach($row as $k => $v)
			$content['elements'][$i][$k] = stripslashes($v);

		if (isset($_POST['element_'.stripslashes($row['id'])]))
			$content['elements'][$i]['show_checked_checkbox'] = "yes";
		else
			$content['elements'][$i]['show_checkbox'] = "yes";
		
		if (1 == $user['id'] || $user['id'] == $user_id)
			$content['elements'][$i]['show_admin_link'] = "yes";

		$i++;
	}
	mysqli_free_result($result);


	/* Satellite sending part */
	if ($i && (in_array("satellites", $config['modules']['installed']) || in_array("bbcpanel", $config['modules']['installed'])))
	{
		$sections_table = "ksh_".$config['modules']['current_module']."_categories";
		$content['categories_select'] = $cat -> get_select("ksh_bbcpanel_categories", $post_categories);
		$content['sections_select'] = $cat -> get_select($sections_table, $post_sections);
	}

	if (isset($_POST['do_search']))
	{
		$content['show_send_form'] = "yes";

		if (!isset($post_sections[0]) || "0" == $post_sections[0])
		{
			$content['all_sections_selected'] = "yes";
			$all_sections = $cat -> get_ids($sections_table);
			$post_sections = array_merge($post_sections, $all_sections);
		}
		
		$sql_query = "SELECT `id`, `title`, `url` FROM `ksh_bbcpanel_bbs`";
		if (isset($post_categories[0]) && "0" != $post_categories[0])
		{
			$categories_qty = count($post_categories);
			if (1 == $categories_qty)
				$sql_query .= " WHERE `category` = '".db_escape($post_categories[0])."'";
			else
				foreach ($post_categories as $k => $v)
				{
					if (0 == $k)
						$sql_query .= " WHERE `category` = '".db_escape($post_categories[0])."'";
					else
						$sql_query .= " OR `category` = '".db_escape($post_categories[$k])."'";
				}
		}
		else
			$content['all_categories_selected'] = "yes";
		$sql_query .= " ORDER BY `id`";


		$result = exec_query($sql_query);
		$i = 0;
		while ($row = mysqli_fetch_array($result))
		{

			$sat = new Satellite;
			$sat -> id = stripslashes($row['id']);
			$sat -> url = stripslashes($row['url']);
			$sat_modules = $sat -> get_open_modules();
			foreach ($sat_modules as $sm_idx => $sm_value)
				$sat_modules_list[] = $sm_value['name'];

			if (in_array($config['modules']['current_module'], $sat_modules_list))
			{
				debug("satellite has current module as open");

				$config_elements = $sat -> get_config("ksh_".$config['modules']['current_module']."_config");
				debug("config elements:", 2);
				dump($config_elements);
				foreach ($config_elements as $ce_idx => $ce_value)
					if ("sections" == $ce_value['name'])
						$sections_string = $ce_value['value'];
				debug("sections string: ".$sections_string);

				$sections = explode("|", stripslashes($sections_string));
				$bb_allsections = array();
				foreach ($sections as $k => $v)
				{
					if ("subcats" == substr($v, 0, 7))
					{
						$parent = substr($v, 8);
						$bb_allsections[] = $parent;
						$subsections = $cat -> get_categories_list($sections_table, $parent);
						$bb_allsections = array_merge($bb_allsections, $subsections);
					}
					else
						$bb_allsections[] = $v;
				}

				$intersect = array_intersect($bb_allsections, $post_sections);
				if (count($intersect) > 0)
				{
					$content['satellites_2send'][$i]['id'] = stripslashes($row['id']);
					$content['satellites_2send'][$i]['title'] = stripslashes($row['title']);
					$content['satellites_2send'][$i]['sects'] = stripslashes($sections_string);
					$content['satellites_2send'][$i]['theme'] = "/themes/".$config['themes']['current'];

					$content['satellites_2send'][$i]['sections'] = "";

					$sections = explode("|", stripslashes($sections_string));
					foreach ($sections as $k => $v)
					{
						debug ("proceeding section ".$v);
						if ("subcats" == substr($v, 0, 7))
						{
							$parent = substr($v, 8);

							$parent_info = $cat -> get_category($sections_table, $parent);
							if(in_array($parent, $post_sections))
								$parent_info['checked'] = "checked";
							$parent_info['bb_id'] = stripslashes($row['id']);
							debug("parent_info:");
							dump($parent_info);
					
							$content['satellites_2send'][$i]['sections'] .= gen_content("bills", "list_sections_checkboxes", $parent_info);
							$cboxes = $cat -> get_checkboxes($sections_table, $post_sections, $parent);
							foreach ($cboxes as $idx => $value)
							{
								$value['bb_id'] = stripslashes($row['id']);
								$content['satellites_2send'][$i]['sections'] .= gen_content("bills", "list_sections_checkboxes", $value);
							}

						}
						else
						{
							$section_info = $cat -> get_category($sections_table, $v);
							if(in_array($v, $post_sections))
								$section_info['checked'] = "checked";
							$section_info['bb_id'] = stripslashes($row['id']);
							debug("section_info:");
							dump($section_info);
					
							$content['satellites_2send'][$i]['sections'] .= gen_content("bills", "list_sections_checkboxes", $section_info);

						}
					}
					$i++;
				}
			}
			else
				debug("satellite doesn't has current module as open");
		}
		mysqli_free_result($result);
	}

	debug ("POST:");
	dump($_POST);
	if(isset($_POST['do_send']))
	{
		debug("trying to send elements");
		$bbs = array();
		$bills = array();
		debug("POST:");
		dump($_POST);
		foreach($_POST as $k => $v)
		{
			if ("bb_" == substr($k, 0, 3))
			{
				$bb_data = explode("_", substr($k, 3));
				debug ("bb & section:");
				dump($bb_data);
				$bbs[$bb_data[0]][] = $bb_data[1];
			}

			if ("bill_" == substr($k, 0, 5))
			{
				$bills[] = substr($k, 5);
			}
		}
		debug("BBs and sections to send bills:");
		dump($bbs);
		debug("Bills to send:");
		dump($bills);

		$bills_qty = count($bills);
		debug("bills qty: ".$bills_qty);
		$i = 0;

		switch($_POST['send_type'])
		{
			default: break;

			case "1":
				// Все объявления на всех досках (1 объявление на доску в первый по списку раздел)
				debug("sending by type 1");
				foreach ($bbs as $bb => $sections)
				{
					debug("bb: ".$bb);
					$sat = new Satellite;
					$sat -> id = stripslashes($bb);
					$sat -> url = $sat -> get_url($bb);
					debug("sections:");
					dump($sections);
					$bill = $this -> get($bills[$i]);
					debug("bill:", 2);
					dump($bill);
					$data = array();
					$desc = array();
					foreach($bill as $k => $v)
					{
						$desc[$k] = "string";
						$data[$k] = $v;
					}
					$data['category'] = $sections[0];
					debug("desc:", 2);
					dump($desc);
					debug("data:", 2);
					dump($data);

					$sat -> send_element("ksh_".$config['modules']['current_module'], "insert", $data, $desc);

					$i++;
					if ($i == $bills_qty)
						$i = 0;
				}

			break;

			case "2":
				// Все объявления на всех разделах всех досок
				debug("sending by type 2");
				foreach ($bbs as $bb => $sections)
				{
					debug("bb: ".$bb);
					$sat = new Satellite;
					$sat -> id = stripslashes($bb);
					$sat -> url = $sat -> get_url($bb);					
					debug("sections:");
					dump($sections);

					foreach ($sections as $sections_k => $section)
					{
						foreach ($bills as $bills_k => $bill_id)
						{
							$bill = $this -> get($bill_id);
							$bill['category'] = $section;
							debug("bill:");
							dump($bill);
							$data = array();
							$desc = array();
							foreach($bill as $k => $v)
							{
								$desc[$k] = "string";
								$data[$k] = $v;
							}
							$data['category'] = $sections[0];
							debug("desc:", 2);
							dump($desc);
							debug("data:", 2);
							dump($data);

							$sat -> send_element("ksh_".$config['modules']['current_module'], "insert", $data, $desc);
						}
					}
				}

			break;

			case "3":
				// Ротация по разделам
				$i = 0;
				foreach ($bbs as $bb => $sections)
				{
					debug("bb: ".$bb);
					$sat = new Satellite;
					$sat -> id = stripslashes($bb);
					$sat -> url = $sat -> get_url($bb);

					debug("sections:");
					dump($sections);

					foreach ($sections as $sections_k => $section)
					{
						$bill = $this -> get($bills[$i]);
						$bill['category'] = $section;
						debug("bill:");
						dump($bill);
						$data = array();
						$desc = array();
						foreach($bill as $k => $v)
						{
							$desc[$k] = "string";
							$data[$k] = $v;
						}
						$data['category'] = $sections[0];
						debug("desc:", 2);
						dump($desc);
						debug("data:", 2);
						dump($data);

						$sat -> send_element("ksh_".$config['modules']['current_module'], "insert", $data, $desc);

						$i++;
						if ($i == $bills_qty)
							$i = 0;
					}
				}
			break;

			case "4":
				// Ротация по доскам
				$i = 0;
				foreach ($bbs as $bb => $sections)
				{
					debug("bb: ".$bb);
					$sat = new Satellite;
					$sat -> id = stripslashes($bb);
					$sat -> url = $sat -> get_url($bb);					
					debug("sections:");
					dump($sections);

					$bill = $this -> get($bills[$i]);

					foreach ($sections as $sections_k => $section)
					{
						$bill['category'] = $section;
						debug("bill:");
						dump($bill);
						$data = array();
						$desc = array();
						foreach($bill as $k => $v)
						{
							$desc[$k] = "string";
							$data[$k] = $v;
						}
						$data['category'] = $sections[0];
						debug("desc:", 2);
						dump($desc);
						debug("data:", 2);
						dump($data);

						$sat -> send_element("ksh_".$config['modules']['current_module'], "insert", $data, $desc);
					}

					$i++;
					if ($i == $bills_qty)
						$i = 0;
				}
			break;
		}

	}
	/* end: Satellite sending part */

	debug ("*** end: DataObject: view_by_user ***");
	return $content;	
}

function add()
{
	global $user;
	global $config;
	debug ("*** DataObject: add ***");
	$content = array(
		'content' => '',
		'result' => '',
		'categories_select' => '',
		'show_admin_link' => '',
		'category' => '',
		'session_name' => '',
		'session_id' => '',
		'title' => '',
		'full_text' => '',
		'module' => '',
		'action' => '',
		'name' => '',
		'if_show_captcha' => ''
	);

	$cat = new Category();
	$priv = new Privileges();

	if (isset($_POST['category']))
		$category_id = $_POST['category'];
	else if (isset($_GET['element']))
		$category_id = $_GET['element'];
	else
		$category_id = 0;

	if ("yes" == $config['base']['use_captcha'] || 
		(isset($config[$config['modules']['current_module']]['use_captcha']) && 
		"yes" == $config[$config['modules']['current_module']]['use_captcha']))
	{
		$content['show_captcha'] = "yes";
		$content['session_name'] = session_name();
		$content['session_id'] = session_id();
	}
/*
	if ("bills" != $config['modules']['default_module'])
		$content['module'] = "/bills";
	if ("view_by_category" != $config['bills']['default_action'])
		$content['action'] = "/view_by_category";
*/	

	$content['category'] = $category_id;
	$content['categories_select'] = $cat -> get_select($this -> categories_table, $category_id);

	if (isset($config['base']['inst_root']))
		$content['inst_root'] = $config['base']['inst_root'];
	if ("" == $content['module'] && "" == $content['action'])
		$content['inst_root'] = rtrim($content['inst_root'], "/");

	if ($priv -> has($config['modules']['current_module'], "add", "write"))
	{
		debug ("user has rights");
		if (isset($_POST['do_add']))
		{
			if ("yes" == $config['base']['use_captcha'] || 
				(isset($config[$config['modules']['current_module']]['use_captcha']) && 
				"yes" == $config[$config['modules']['current_module']]['use_captcha']))
			{
				if(isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] ==  $_POST['keystring'])
					$result = 1;
				else
				{
					$result = 0;
					$content['result'] .= "Неправильно введено проверочное слово.";
				}
			}
			else
				$result = 1;

			if (isset($_POST['required_fields']))
				foreach ($_POST['required_fields'] as $k => $v)
					if ("" == $_POST[$v])
					{
						$result = 0;
						$content['result'] .= " Заполнены не все необходимые поля.";
					}

			if ($result)
			{
				if (!isset($_POST['name']) || "" == $_POST['name'])
					$_POST['name'] = $this -> generate_unique_name($this -> table, $_POST['title']);

				$_POST['name'] = str_replace("/", "", $_POST['name']);

				unset($_POST['do_add']);
				unset($_POST['required_fields']);
				debug("POST:", 2);
				dump($_POST);

				$sql_query = "SHOW COLUMNS FROM `".db_escape($this -> table)."`";
				$result = exec_query($sql_query);
				$db_fields = array();
				while ($row = mysqli_fetch_array($result))
				{
					debug("row:", 2);
					dump($row);
					$db_fields[] = $row['Field'];
				}
				mysqli_free_result($result);

				$fields = "";
				$values = "";
				foreach($db_fields as $k => $v)
				{
					if (isset($_POST[$v]))
					{
						$fields .= "`".db_escape($v)."`,";
						$values .= "'".db_escape($_POST[$v])."',";
					}
				}
				$fields = rtrim($fields, ",");
				$values = rtrim($values, ",");

				if (in_array("user",  $db_fields))
				{
					$fields .= ", `user`";
					$values .= ", '".db_escape($user['id'])."'";
				}

				if (in_array("date",  $db_fields) && !isset($_POST['date']))
				{
					$fields .= ", `date`";
					$values .= ", '".db_escape(date("Y-m-d"))."'";
				}

				if (in_array("time",  $db_fields))
				{
					$fields .= ", `time`";
					$values .= ", '".db_escape(date("H:i:s"))."'";
				}

				if (in_array("datetime",  $db_fields))
				{
					$fields .= ", `datetime`";
					$values .= ", '".db_escape(date("Y-m-d H:i:s"))."'";
				}

				$sql_query = "INSERT INTO `".db_escape($this -> table)."` (".$fields.") VALUES (".$values.")";
				debug($sql_query);

				exec_query($sql_query);
				if (0 == mysql_errno())
				{
					$content['result'] = "Добавление прошло успешно";

					if (isset($config['bbcpanel']['bbcpanel_domain']) && "" != $config['bbcpanel']['bbcpanel_domain'])
					{
						debug("sending data to control panel");
						$data_desc = array();
						$data = array();
						
						unset($_POST['keystring']);
						unset($_POST['do_add']);

						$_POST['id'] = mysql_insert_id();
						$_POST['date'] = date("Y-m-d");
						$_POST['user'] = $user['id'];

						foreach($_POST as $k => $v)
						{
							$data_desc[$k] = "string";
							$data[$k] = $v;
						}

						if ("yes" == $config['satellite']['use'])
						{
							$sat = new Satellite;
							$sat -> url = $config['bbcpanel']['bbcpanel_domain'];
							$sat -> send_element($config[$config['modules']['current_module']]['table']."_".$config['bbcpanel']['bb_id'], "insert", $data, $data_desc, "1");
							$sat -> do_action($config['modules']['current_module']."|inform_moderators|".$config['bbcpanel']['bb_id']."_".$_POST['id']);
						}
					}
				}
				else
					$content['result'] = "Не удалось добавить, ошибка базы данных";
			}
			else
			{
				unset($_SESSION['captcha_keystring']);
				foreach($_POST as $k => $v)
					$content[$k] = $v;
			}
		}
	}
	else
		$content['result'] = "Недостаточно прав";

	debug ("*** end: DataObject: add ***");
	return $content;	
}

function edit($element = 0)
{
	global $user;
	global $config;
	debug ("*** DataObject: edit ***");
	$content = array(
		'content' => '',
		'result' => '',
		'show_admin_link' => '',
		'id' => '',
		'title' => '',
		'full_text' => '',
		'bills' => '',
		'category_title' => '',
		'category' => '',
		'bbs' => '',
		'show_my_bills_link' => '',
		'name' => '',
		'satellite' => '',
		'action' => $_GET['action']
	);

	$cat = new Category();
	$priv = new Privileges();


	if(isset($_GET['satellite']))
		$satellite = $_GET['satellite'];
	else if (isset($_POST['satellite']))
	{
		$satellite = $_POST['satellite'];
		unset($_POST['satellite']);
	}
	else
		$satellite = 0;


	if (isset($_POST['do_update']))
	{
		debug ("have element to update");
		unset($_POST['do_update']);
		if ($priv -> has($config['modules']['current_module'], "edit", "write") || $priv -> has($config['modules']['current_module'], "moderate_edit", "write"))
		{
			debug ("user has edit rights");

			if ("" == $_POST['name'])
				$_POST['name'] = $this -> generate_unique_name($this -> table, $_POST['title']);

			$_POST['name'] = str_replace("/", "", $_POST['name']);

			$sql_query = "SHOW COLUMNS FROM `".db_escape($this -> table)."`";
			$result = exec_query($sql_query);
			$db_fields = array();
			while ($row = mysqli_fetch_array($result))
			{
				debug("row:", 2);
				dump($row);
				$db_fields[] = $row['Field'];
			}
			mysqli_free_result($result);

			$sql_query = "UPDATE `".db_escape($this -> table)."` SET ";
			foreach($db_fields as $k => $v)
				if (isset($_POST[$v]))
					$sql_query .= "`".db_escape($v)."` = '".db_escape($_POST[$v])."',";
			$sql_query = rtrim($sql_query, ",")." WHERE `id` = '".db_escape($element)."'";

			exec_query($sql_query);
			if (0 != mysql_errno())
				$content['result'] = "Не удалось обновить запись, ошибка базы данных";
			else
			{
				$content['result'] = "Обновление успешно записано";

				if($satellite || (isset($config['bbcpanel']['bbcpanel_domain']) && "" != $config['bbcpanel']['bbcpanel_domain']))
				{
					$sat = new Satellite();
					if ($satellite)
					{
						debug("sending data to satellite");
						$sat -> id = $satellite;
						$sat -> url = $sat -> get_url();
						$table = $config[$config['modules']['current_module']]['table'];

					}
					else
					{
						debug("sending data to control panel");
						$sat -> url = $config['bbcpanel']['bbcpanel_domain'];
						$table = $config[$config['modules']['current_module']]['table']."_".$config['bbcpanel']['bb_id'];
					}
					$data_desc = array();
					$data = array();

					foreach($db_fields as $k => $v)
						if (isset($_POST[$v]))
						{
							$data_desc[$v] = "string";
							$data[$v] = $_POST[$v];
						}

					$sat -> send_element($table, "update", $data, $data_desc);
					$sat -> do_action($config['modules']['current_module']."|inform_moderators|".$config['bbcpanel']['bb_id']."_".$_POST['id']);
					
				}
			}
		}
		else
			debug ("Нет прав на запись");
	}

	if($satellite)
	{
		$content['satellite'] = $satellite;
		$sat = new Satellite;
		$sat -> id = $satellite;
		$sat -> url = $sat -> get_url();
		$content = array_merge($content, $sat -> get_element($config[$config['modules']['current_module']]['table'], $element));
	}
	else
	{

		$content = array_merge($content, $this -> get($element));
		if (isset($content['category']) && "" != $content['category'])
		{
			$content['category_title'] = $cat -> get_title($this -> categories_table, $content['category']);
			$content['categories_select'] = $cat -> get_select($this -> categories_table, $content['category']);
		}

	}

	debug ("*** end: DataObject: edit ***");
	return $content;	
}

function get($id)
{
	global $user;
	global $config;
	debug ("*** DataObject: get ***");

	$element = array();

	$sql_query = "SELECT * FROM `".db_escape($this -> table)."` WHERE `id` = '".db_escape($id)."'";
	$result = exec_query($sql_query);
	$row = mysqli_fetch_array($result, MYSQL_ASSOC);
	mysqli_free_result($result);

	if ($row)
		foreach ($row as $k => $v)
		{
			debug($k.":".$v);
			$element[$k] = stripslashes($v);

			if ("date" == $k)
				$element['date'] = format_date($v, $config['base']['lang']['current']);
		}
	
	debug ("*** end: DataObject: get ***");
	return $element;
}

function get_id_by_name($name)
{
	global $user;
	global $config;
	debug("*** DataObject: get_id_by_name ***");

	debug("name: ".$name);

	$name = urldecode($name);

	$sql_query = "SELECT `id` FROM `".db_escape($this -> table)."` WHERE `name` = '".db_escape($name)."'";
	$result = exec_query($sql_query);
	$row = mysqli_fetch_array($result);
	mysqli_free_result($result);

	$id = stripslashes($row['id']);
	debug("id: ".$id);

	debug("*** end: DataObject: get_id_by_name ***");
	return $id;
}

function view($id = 0)
{
	global $user;
	global $config;
	global $template;

	debug ("*** DataObject: view ***");
	$content = array(
		'content' => '',
		'result' => '',
		'show_admin_link' => '',
		'id' => '',
		'title' => '',
		'full_text' => '',
		'bills' => '',
		'category_name' => '',
		'category_title' => '',
		'category' => '',
		'date' => '',
		'user' => '',
		'resemble_elements' => '',
		'module' => '',
		'action' => ''
	);


	$cat = new Category();
	

	if(!is_numeric($id))
		$id = $this -> get_id_by_name($id);

	$content = array_merge($content, $this -> get($id));
	if (isset($content['category']) && "" != $content['category'])
	{
		$content['category_id'] = $content['category'];
		$content['category_name'] = $cat -> get_name($this -> categories_table, $content['category']);
		$content['category_title'] = $cat -> get_title($this -> categories_table, $content['category']);
		$content['categories_select'] = $cat -> get_select($this -> categories_table, $content['category']);
	}

	if ("" != $content['category_name'] && NULL != $content['category_name'])
		$content['category'] = $content['category_name'];

	$config['themes']['page_title']['element'] = $content['title'];

	$parents_list = $cat -> get_parents_list($this -> categories_table, $content['category']);
	foreach ($parents_list as $k => $v)
		if ($v)
			$config['themes']['page_title']['categories_title'][]['title'] = $cat -> get_title($this -> categories_table, $v);
	$config['themes']['page_title']['categories_title'][]['title'] = $content['category_title'];

	// Get resemble elements
	if (isset ($config[$config['modules']['current_module']]['resemble_elements_qty']) 
			&& $config[$config['modules']['current_module']]['resemble_elements_qty'] > 0)
	{
		debug("getting resemble elements");
		$sql_query = "SELECT COUNT(*) FROM `".db_escape($this -> table)."` 
			WHERE `category` = '".$content['category_id']."' 
			AND `id` < '".$content['id']."'
			ORDER BY `id` DESC";
		$result = exec_query($sql_query);
		$count_row = mysqli_fetch_array($result);
		mysqli_free_result($result);
		$elements_before_qty = stripslashes($count_row['COUNT(*)']);
		debug("elements before: ".$elements_before_qty);

		if ($elements_before_qty < $config[$config['modules']['current_module']]['resemble_elements_qty'])
			$elements_after_qty = $config[$config['modules']['current_module']]['resemble_elements_qty'] - $elements_before_qty;
		else
			$elements_after_qty = 0;
		debug("elements after: ".$elements_after_qty);
	
	
		$sql_query = "SELECT `id` FROM `".db_escape($this -> table)."` 
			WHERE `category` = '".$content['category_id']."' 
			AND `id` < '".$content['id']."'
			ORDER BY `id` DESC LIMIT ".$config[$config['modules']['current_module']]['resemble_elements_qty'];
		$result = exec_query($sql_query);
		$i = 0;
		while ($el = mysqli_fetch_array($result))
		{
			$element = $this -> get(stripslashes($el['id'])); 
			$content['resemble_elements'][$i] = $element;
			if ("" == $element['name'])
				$content['resemble_elements'][$i]['name'] = $element['id'];
			if ($config['modules']['current_module'] != $config['modules']['default_module'])
				$content['resemble_elements'][$i]['module'] = "/".$config['modules']['current_module'];

			if (isset($config['base']['inst_root']))
				$content['resemble_elements'][$i]['inst_root'] = $config['base']['inst_root'];
			if ("" == $content['resemble_elements'][$i]['module'])
				$content['resemble_elements'][$i]['inst_root'] = rtrim($content['resemble_elements'][$i]['inst_root'], "/");

			$i++;
		}
		mysqli_free_result($result);

		if ($elements_after_qty)
		{
			$sql_query = "SELECT `id` FROM `".db_escape($this -> table)."` 
				WHERE `category` = '".$content['category_id']."' 
				AND `id` > '".$content['id']."'
				ORDER BY `id` ASC LIMIT ".$config[$config['modules']['current_module']]['resemble_elements_qty'];
			$result = exec_query($sql_query);
			while ($el = mysqli_fetch_array($result))
			{
				$element = $this -> get(stripslashes($el['id']));
				$content['resemble_elements'][$i] = $element; 
				if ($config['modules']['current_module'] != $config['modules']['default_module'])
					$content['resemble_elements'][$i]['module'] = "/".$config['modules']['current_module'];			

				if (isset($config['base']['inst_root']))
					$content['resemble_elements'][$i]['inst_root'] = $config['base']['inst_root'];					
				if ("" == $content['resemble_elements'][$i]['module'])
					$content['resemble_elements'][$i]['inst_root'] = rtrim($content['resemble_elements'][$i]['inst_root'], "/");

				$i++;
			}
			mysqli_free_result($result);
		}
	}
	
	debug ("*** end: DataObject: view ***");
	return $content;	
}


function del($element)
{
	global $user;
	global $config;
	debug ("*** DataObject: del ***");
	$content = array(
		'content' => '',
		'id' => '',
		'title' => '',
		'category' => '',
		'satellite' => '',
		'action' => '',
		'show_del_form' => 'yes'
	);

	if(isset($_GET['satellite']))
		$satellite = $_GET['satellite'];
	else if (isset($_POST['satellite']))
	{
		$satellite = $_POST['satellite'];
		unset($_POST['satellite']);
	}
	else
		$satellite = 0;

	$priv = new Privileges();

	$content = array_merge($content, $this -> get($element));

	if (isset($_POST['do_del']))
	{
		debug ("have element to delete");
		$content['show_del_form'] = "";

		if ($priv -> has($config['modules']['current_module'], "del", "write") || $priv -> has($config['modules']['current_module'], "moderate_del", "write"))
		{
			debug ("user has delete rights");

			if(isset($_POST['satellite']))
				$satellite = $_POST['satellite'];
			else if (isset($_GET['satellite']))
				$satellite = $_GET['satellite'];
			else
				$satellite = 0;

			if ($satellite)
			{
				debug("deleting from satellite");

				$sat = new Satellite;
				$sat -> id = $satellite;
				$sat -> url = $sat -> get_url();
				$result_del = $sat -> del_element($config[$config['modules']['current_module']]['table'], $_POST['id']);
				debug("result del: ".$result_del);
			}
			else if ("yes" == $config['satellite']['use'] && isset($config['bbcpanel']['bbcpanel_domain']) && "" != $config['bbcpanel']['bbcpanel_domain'])
			{
				debug("deleting from control panel");
				$sat = new Satellite;
				$sat -> url = $config['bbcpanel']['bbcpanel_domain'];
				$sat -> del_element($config[$config['modules']['current_module']]['table']."_".$config['bbcpanel']['bb_id'], $_POST['id']);
			}

			$sql_query = "DELETE FROM `".db_escape($this -> table)."` WHERE `id` = '".db_escape($element)."'";
			exec_query($sql_query);
			if (0 == mysql_errno())
				$content['result'] = "Удаление прошло успешно";
			else
				$content['result'] = "Не удалось удалить, ошибка базы данных";
		}
		else
			debug ("user doesn't have delete rights");
	}


	if ($satellite)
	{
		$content['satellite'] = $satellite;
		$content['action'] = "moderate_del";
		$sat = new Satellite;
		$sat -> id = $satellite;
		$sat -> url = $sat -> get_url();
		$content = array_merge($content, $sat -> get_element($config[$config['modules']['current_module']]['table'], $element));
	}
	else
		$content = array_merge($content, $this -> get($element));
/*
	if ("view_by_category" != $content['action'])
		$content['category'] = $content['id'];
*/

	debug ("*** end: DataObject: del ***");
	return $content;	
}




}

?>
