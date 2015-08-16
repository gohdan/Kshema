<?php

// Base functions of the "shop" module

include_once ("db.php");
include_once ("categories.php");
include_once ("authors.php");
include_once ("goods.php");
include_once ("users.php");
include_once ("cart.php");
include_once ("orders.php");
include_once ("requests.php");
include_once ("demand.php");


include ($config['modules']['location']."/files/index.php"); // to upload pictures

function shop_admin()
{
	debug ("*** shop_admin ***");
    $content['content'] = "";
	debug ("*** end: shop_admin ***");
    return $content;
}

function shop_frontpage()
{
    global $config;	
	global $user;
	debug ("*** shop_frontpage ***");
	$content = array(
		'content' => '',
		'goods_last' => ''
	);
   	$lastitems = $config['shop']['lastitems'];

	if ("1" == $user['id'])
		$content['show_admin_link'] = "yes";

	$i = 0;
	
    $result = exec_query ("SELECT `id`, `name` FROM `ksh_shop_categories`");
	if ($result && mysql_num_rows($result))
	{
	    while ($row = mysql_fetch_array($result))
			$categories[] = $row;
	    mysql_free_result ($result);

	    foreach ($categories as $ck => $cv)
    	{
			$sql_query = "SELECT COUNT(*) FROM `ksh_shop_goods` WHERE category='".$cv['id']."' AND (`if_hide` IS NULL OR `if_hide` != '1')";
			$goods_qty = mysql_result(exec_query($sql_query), 0, 0);
			debug ("goods qty: ".$goods_qty);
	        if (0 != $goods_qty)
    	    {
				debug("there are goods, processing");
				$content['goods_last'][$i]['begin_row'] = "yes";
				$content['goods_last'][$i]['lastitems_qty'] = $lastitems;
				$content['goods_last'][$i]['category_title'] = stripslashes($cv['name']);
		        unset ($goods);

				$sql_query = "SELECT `id`, `name`, `image` FROM `ksh_shop_goods` 
					WHERE category='".$cv['id']."'
					AND (`if_hide` IS NULL OR `if_hide` != '1')
					ORDER BY `id` DESC LIMIT ".$lastitems;
		        $result = exec_query ($sql_query);
		        while ($row = mysql_fetch_array($result))
					$goods[] = $row;
	        	mysql_free_result($result);

				$j = 0;
		        foreach ($goods as $k => $v)
	    	    {
					debug("processing good ".$k.", i=".$i.", j=".$j);
					$content['goods_last'][$i]['id'] = stripslashes($v['id']);
					$content['goods_last'][$i]['image'] = stripslashes($v['image']);
					$content['goods_last'][$i]['name'] = stripslashes($v['name']);
					$i++;
					$j++;
	
					if ($j == $lastgoods)
					{
						$content['goods_last'][$i]['end_row'] = "yes";
				        if ("yes" == $config['shop']['show_last_goods_link'])
						{
							$content['goods_last'][$i]['show_last_goods_link'] = "yes";
							$content['goods_last'][$i]['category_id'] = stripslashes($cv['id']);
							$content['goods_last'][$i]['category_title'] = stripslashes($cv['name']);
							$content['goods_last'][$i]['lastitems_qty'] = $lastitems;
						}
					}
				}
	        }
    	}
	}

    debug ("*** end: shop_frontpage ***");
    return $content;
}

function shop_read_csv()
{
	debug ("*** shop_read_csv ***");
    global $config;
    global $user;
    $content = array(
    	'content' => '',
        'result' => '',
		'code' => '',
		'name' => '',
		'category' => '',
		'author' => ''
    );

	$file_path = $config['base']['doc_root'].$config['base']['domain_dir']."/modules/shop/data.csv";
	debug ("CSV file path: ".$file_path);
	$handle = fopen ($file_path,"r");
	while ($data = fgetcsv ($handle, 1000, ";"))
    {
        $content['id'] = $data[0];
        $content['name'] = $data[1];

		$content['category'] = 1;
		$content['author'] = 1;

        exec_query("INSERT INTO ksh_shop_goods (category, author, code, name) values ('".mysql_real_escape_string($content['category'])."', '".mysql_real_escape_string($content['author'])."', '".mysql_real_escape_string($content['code'])."', '".mysql_real_escape_string($content['name'])."')");
	}
	fclose ($handle);

    debug ("*** end: shop_read_csv ***");
    return $content;
}



function shop_default_action()
{
	global $config;
    global $user;
	
	debug("<br>=== mod: shop ===");
	
	$content = "";
	if (isset($_GET['category']))
		$config['modules']['current_category'] = $_GET['category'];


        if (isset($_GET['action']))
        {
				debug ("*** action: ".$_GET['action']);

				if (in_array($_GET['action'], $config['shop']['admin_actions']))
						$config['themes']['admin'] = "yes";

                switch ($_GET['action'])
                {
                        default:
                                $content .= gen_content("shop", "frontpage", shop_frontpage());
                        break;

						case "admin":
                                $content .= gen_content("shop", "admin", shop_admin());
                        break;

                        case "install_tables":
                                $content .= gen_content("shop", "install_tables", shop_install_tables());
                        break;

                        case "drop_tables":
                                $content .= gen_content("shop", "drop_tables", shop_drop_tables());
                        break;

                        case "update_tables":
                                $content .= gen_content("shop", "update_tables", shop_update_tables());
                        break;

						case "categories_view":
							$content .= gen_content("shop", "categories_view", shop_categories_view());
						break;

						case "categories_add":
							$content .= gen_content("shop", "categories_add", shop_categories_add());
						break;

						case "categories_edit":
							$content .= gen_content("shop", "categories_edit", shop_categories_edit());
						break;

						case "categories_del":
							$content .= gen_content("shop", "categories_del", shop_categories_del());
						break;

						case "authors_view":
							$content .= gen_content("shop", "authors_view", shop_authors_view());
						break;

						case "authors_view_by_category":
							$content .= gen_content("shop", "authors_view_by_category", shop_authors_view_by_category());
						break;

						case "authors_add":
							$content .= gen_content("shop", "authors_add", shop_authors_add());
						break;

						case "authors_edit":
							$content .= gen_content("shop", "authors_edit", shop_authors_edit());
						break;

						case "authors_del":
							$content .= gen_content("shop", "authors_del", shop_authors_del());
						break;

						case "goods_view_all":
							$content .= gen_content("shop", "goods_view_all", shop_goods_view_all());
						break;

						case "goods_view_hidden":
							$content .= gen_content("shop", "goods_view_hidden", shop_goods_view_hidden());
						break;

						case "goods_add":
							$content .= gen_content("shop", "goods_add", shop_goods_add());
						break;

						case "goods_edit":
							$content .= gen_content("shop", "goods_edit", shop_goods_edit());
						break;

						case "goods_del":
							$content .= gen_content("shop", "goods_del", shop_goods_del());
						break;

						case "view_by_categories":
                            $content = gen_content("shop", "view_by_categories", shop_view_by_categories());
                        break;

                        case "view_by_authors":
                            $content = gen_content("shop", "view_by_authors", shop_view_by_authors());
                        break;

                        case "view_by_tag":
                            $content = gen_content("shop", "view_by_tag", shop_view_by_tag());
                        break;

						case "view_popular":
                            $content = gen_content("shop", "view_popular", shop_view_popular());
                        break;

						case "view_new":
                            $content = gen_content("shop", "view_new", shop_view_new());
                        break;

						case "view_recommended":
                            $content = gen_content("shop", "view_recommended", shop_view_recommended());
                        break;

                        case "view_good":
                            $content = gen_content("shop", "view_good", shop_view_good());
                        break;

						case "users_view":
                            $content = gen_content("shop", "users_view", shop_users_view());
                        break;

						case "user_del":
							$content = gen_content("shop", "user_del", shop_user_del());
						break;

						case "cart_add":
                            $content = gen_content("shop", "cart_add", shop_cart_add());
                        break;

						case "cart_add_multiple":
                            $content = gen_content("shop", "cart_add_multiple", shop_cart_add_multiple());
                        break;

						case "cart_view":
                            $content = gen_content("shop", "cart_view", shop_cart_view());
                        break;

						case "cart_del":
                            $content = gen_content("shop", "cart_del", shop_cart_del());
                        break;

						case "order_create":
                            $content = gen_content("shop", "orders_create", shop_orders_create());
                        break;

						case "order_send":
                            $content = gen_content("shop", "orders_send", shop_orders_send());
                        break;

						case "orders_view_all":
                            $content = gen_content("shop", "orders_view_all", shop_orders_view_all());
                        break;

						case "orders_view":
                            $content = gen_content("shop", "orders_view", shop_orders_view());
                        break;

						case "orders_view_by_user":
                            $content = gen_content("shop", "orders_view_by_user", shop_orders_view_by_user());
                        break;

						case "orders_del":
                            $content = gen_content("shop", "orders_del", shop_orders_del());
                        break;

						case "orders_cancel":
                            $content = gen_content("shop", "orders_cancel", shop_orders_cancel());
                        break;

						case "requests_view":
							$content = gen_content("shop", "requests_view", shop_requests_view());
						break;

						case "requests_add":
							$content = gen_content("shop", "requests_add", shop_requests_add());
						break;

						case "requests_del":
							$content = gen_content("shop", "requests_del", shop_requests_del());
						break;

						case "read_csv":
							$content = gen_content("shop", "read_csv", shop_read_csv());
						break;

						case "demand_add":
							$content = gen_content("shop", "demand_add", shop_demand_add());
						break;

						case "demand_view":
							$content = gen_content("shop", "demand_view", shop_demand_view());
						break;

						case "demand_del":
							$content = gen_content("shop", "demand_del", shop_demand_del());
						break;

						case "view_last":
							$content = gen_content("shop", "view_last", shop_view_last());
						break;
                }
        }

        else
        {
                debug ("*** action: default");
                $content = gen_content("shop", "frontpage", shop_frontpage());
        }

        debug("=== end: mod: shop ===<br>");
        return $content;

}

?>
