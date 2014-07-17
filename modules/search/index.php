<?php

// Base functions of the "search" module

function search_main()
{
	global $user;
	global $config;
    debug ("*** search_main ***");
	$content = array(
		'result' => '',
		'search_string' => '',
		'results' => '',
		'inst_root' => '',
		'site_url' => ''
	);

	$content['inst_root'] = trim($config['base']['inst_root'], "/");
	$content['site_url'] = trim($config['base']['site_url'], "/");

    if (isset($_POST['search_string']))
        $search_string = $_POST['search_string'];
    else $search_string = "";


    $content['search_string'] = $search_string;

    if (isset($_POST['do_search']))
    {
        debug ("have something to search");

        if (("" == $search_string) || (" " == $search_string))
        {
            debug ("search string is empty");
            $content['result'] .= "Задан пустой поисковый запрос";
        }
        else
        {
            debug ("search string is not empty");
			$i = 0;

			if (in_array("bills", $config['modules']['installed']))
			{
				debug("searching in bills categories");
				$sql_query = "SELECT * FROM `ksh_bills_categories`
					WHERE 
					`title` LIKE '%".mysql_real_escape_string($search_string)."%'
					";
				$result = exec_query($sql_query);
				$if_show_heading = 1;
				while ($row = mysql_fetch_array($result))
				{
					if ($if_show_heading)
					{
						$content['results'][$i]['heading'] = "Разделы объявлений";
						$if_show_heading = 0;
					}
					$content['results'][$i]['element_type'] = "category";
					$content['results'][$i]['ext'] = "/";
					if ("bills" != $config['modules']['default_module'])
						$content['results'][$i]['module'] = "/bills";
					if ("view_by_category" != $config['bills']['default_action'])
						$content['results'][$i]['action'] = "/view_by_category";
					if ("" != $row['name'] && NULL != $row['name'])
						$content['results'][$i]['id'] = stripslashes($row['name']);
					else
						$content['results'][$i]['id'] = stripslashes($row['id']);
				
					$content['results'][$i]['title'] = stripslashes($row['title']);
					$content['results'][$i]['inst_root'] = $content['inst_root'];
					$content['results'][$i]['site_url'] = $content['site_url'];
					
					$i++;
				}
				mysql_free_result($result);



				debug("searching in bills");
				$sql_query = "SELECT * FROM `ksh_bills`
					WHERE 
					`title` LIKE '%".mysql_real_escape_string($search_string)."%'
					OR
					`full_text` LIKE '%".mysql_real_escape_string($search_string)."%'
					";
				$result = exec_query($sql_query);
				$if_show_heading = 1;
				while ($row = mysql_fetch_array($result))
				{
					if ($if_show_heading)
					{
						$content['results'][$i]['heading'] = "Объявления";
						$if_show_heading = 0;
					}
					if ("bills" != $config['modules']['default_module'])
						$content['results'][$i]['module'] = "/bills";
					/*
					if ("view" != $config['bills']['default_action'])
						$content['results'][$i]['action'] = "/view";
					*/
					$content['results'][$i]['action'] = "";
					$content['results'][$i]['element_type'] = "bill";
					$content['results'][$i]['id'] = stripslashes($row['id']);
					if ("" != $row['name'])
						$content['results'][$i]['name'] = stripslashes($row['name']);
					else
						$content['results'][$i]['name'] = stripslashes($row['id']);
					$content['results'][$i]['title'] = stripslashes($row['title']);
					$content['results'][$i]['text'] = stripslashes($row['full_text']);
					$content['results'][$i]['ext'] = ".html";
					if ("yes" == $config['base']['ext_links_redirect'])
					{
						include_once($config['modules']['location']."redirect/index.php");
						$content['results'][$i]['text'] = redirect_links_replace(stripslashes($row['full_text']));
					}
					else
						$content['results'][$i]['text'] = stripslashes($row['full_text']);

					$content['results'][$i]['inst_root'] = $content['inst_root'];
					$content['results'][$i]['site_url'] = $content['site_url'];

					$i++;
				}
				mysql_free_result($result);

			}


			if (in_array("articles", $config['modules']['installed']))
			{
				debug("searching in articles categories");
				$sql_query = "SELECT * FROM `ksh_articles_categories`
					WHERE 
					`title` LIKE '%".mysql_real_escape_string($search_string)."%'
					";
				$result = exec_query($sql_query);
				$if_show_heading = 1;
				while ($row = mysql_fetch_array($result))
				{
					if ($if_show_heading)
					{
						$content['results'][$i]['heading'] = "Разделы статей";
						$if_show_heading = 0;
					}
					$content['results'][$i]['element_type'] = "category";
					$content['results'][$i]['ext'] = "/";
					if ("articles" != $config['modules']['default_module'])
						$content['results'][$i]['module'] = "/articles";
					if ("view_by_category" != $config['articles']['default_action'])
						$content['results'][$i]['action'] = "/view_by_category";
					if ("" != $row['name'] && NULL != $row['name'])
						$content['results'][$i]['id'] = stripslashes($row['name']);
					else
						$content['results'][$i]['id'] = stripslashes($row['id']);
				
					$content['results'][$i]['title'] = stripslashes($row['title']);
					$content['results'][$i]['inst_root'] = $content['inst_root'];
					$content['results'][$i]['site_url'] = $content['site_url'];

					$i++;
				}
				mysql_free_result($result);



				debug("searching in articles");
				$sql_query = "SELECT * FROM `ksh_articles`
					WHERE 
					`title` LIKE '%".mysql_real_escape_string($search_string)."%'
					OR
					`full_text` LIKE '%".mysql_real_escape_string($search_string)."%'
					";
				$result = exec_query($sql_query);
				$if_show_heading = 1;
				while ($row = mysql_fetch_array($result))
				{
					if ($if_show_heading)
					{
						$content['results'][$i]['heading'] = "Статьи";
						$if_show_heading = 0;
					}
					if ("articles" != $config['modules']['default_module'])
						$content['results'][$i]['module'] = "articles";
					/*
					if ("view" != $config['articles']['default_action'])
						$content['results'][$i]['action'] = "/view";
					*/
					$content['results'][$i]['action'] = "";
					$content['results'][$i]['element_type'] = "article";
					$content['results'][$i]['id'] = stripslashes($row['id']);
					if ("" != $row['name'])
						$content['results'][$i]['name'] = stripslashes($row['name']);
					else
						$content['results'][$i]['name'] = stripslashes($row['id']);
					$content['results'][$i]['title'] = stripslashes($row['title']);
					$content['results'][$i]['text'] = stripslashes($row['full_text']);
					$content['results'][$i]['ext'] = ".html";
					if ("yes" == $config['base']['ext_links_redirect'])
					{
						include_once($config['modules']['location']."redirect/index.php");
						$content['results'][$i]['text'] = redirect_links_replace(stripslashes($row['full_text']));
					}
					else
						$content['results'][$i]['text'] = stripslashes($row['full_text']);

					$content['results'][$i]['inst_root'] = $content['inst_root'];
					$content['results'][$i]['site_url'] = $content['site_url'];
					debug("result ".$i.":", 2);
					dump($content['results'][$i]);
					$i++;
				}
				mysql_free_result($result);

			}

			if (in_array("pages", $config['modules']['installed']))
			{
				debug("searching in pages categories");
				$sql_query = "SELECT * FROM `ksh_pages_categories`
					WHERE 
					`title` LIKE '%".mysql_real_escape_string($search_string)."%'
					";
				$result = exec_query($sql_query);
				$if_show_heading = 1;
				while ($row = mysql_fetch_array($result))
				{
					if ($if_show_heading)
					{
						$content['results'][$i]['heading'] = "Разделы страниц";
						$if_show_heading = 0;
					}

					/*
					$content['results'][$i]['element_type'] = "category";
					$content['results'][$i]['ext'] = "/";
					if ("pages" != $config['modules']['default_module'])
						$content['results'][$i]['module'] = "/pages";
					if (!isset($config['pages']['default_action']) || ("view_by_category" != $config['pages']['default_action']))
						$content['results'][$i]['action'] = "/view_by_category";

					if ("" != $row['name'] && NULL != $row['name'])
						$content['results'][$i]['id'] = stripslashes($row['name']);
					else
						$content['results'][$i]['id'] = stripslashes($row['id']);
					*/

					$content['results'][$i]['name'] = "/index.php?module=pages&action=view_by_category&category=".stripslashes($row['id']);
				
					$content['results'][$i]['title'] = stripslashes($row['title']);
					$content['results'][$i]['inst_root'] = $content['inst_root'];
					$content['results'][$i]['site_url'] = $content['site_url'];

					$i++;
				}
				mysql_free_result($result);



				debug("searching in pages");
				$sql_query = "SELECT * FROM `ksh_pages`
					WHERE 
					`title` LIKE '%".mysql_real_escape_string($search_string)."%'
					OR
					`full_text` LIKE '%".mysql_real_escape_string($search_string)."%'
					";
				$result = exec_query($sql_query);
				$if_show_heading = 1;
				while ($row = mysql_fetch_array($result))
				{
					if ($if_show_heading)
					{
						$content['results'][$i]['heading'] = "Страницы";
						$if_show_heading = 0;
					}
					if ("pages" != $config['modules']['default_module'])
						$content['results'][$i]['module'] = "pages";
					/*
					if ("view" != $config['pages']['default_action'])
						$content['results'][$i]['action'] = "/view";
					*/
					$content['results'][$i]['action'] = "";
					$content['results'][$i]['element_type'] = "page";
					$content['results'][$i]['id'] = stripslashes($row['id']);
					if ("" != $row['name'])
						$content['results'][$i]['name'] = stripslashes($row['name']);
					else
						$content['results'][$i]['name'] = stripslashes($row['id']);
					$content['results'][$i]['title'] = stripslashes($row['title']);
					// $content['results'][$i]['text'] = stripslashes($row['full_text']);
					$content['results'][$i]['ext'] = ".html";
					/*
					if ("yes" == $config['base']['ext_links_redirect'])
					{
						include_once($config['modules']['location']."redirect/index.php");
						$content['results'][$i]['text'] = redirect_links_replace(stripslashes($row['full_text']));
					}
					else
						$content['results'][$i]['text'] = stripslashes($row['full_text']);
					*/

					$content['results'][$i]['inst_root'] = $content['inst_root'];
					$content['results'][$i]['site_url'] = $content['site_url'];
					debug("result ".$i.":", 2);
					dump($content['results'][$i]);
					$i++;
				}
				mysql_free_result($result);

			}


			if (in_array("shop", $config['modules']['installed']))
			{
				debug("searching in shop authors");

				$sql_query = "SELECT * FROM `ksh_shop_authors`
					WHERE 
					`name` LIKE '%".mysql_real_escape_string($search_string)."%'
					";
				$result = exec_query($sql_query);
				$if_show_heading = 1;
				while ($row = mysql_fetch_array($result))
				{
					if ($if_show_heading)
					{
						$content['results'][$i]['heading'] = "Авторы";
						$if_show_heading = 0;
					}
	
					$content['results'][$i]['module'] = "shop";
					$content['results'][$i]['action'] = "view_by_authors";
					$content['results'][$i]['id'] = stripslashes($row['id']);
					$content['results'][$i]['name'] = "authors:".stripslashes($row['id']);
					$content['results'][$i]['ext'] = "";
					$content['results'][$i]['title'] = stripslashes($row['name']);


					$content['results'][$i]['inst_root'] = $content['inst_root'];
					$content['results'][$i]['site_url'] = $content['site_url'];
					debug("result ".$i.":", 2);
					dump($content['results'][$i]);
					$i++;
				}
				mysql_free_result($result);


				debug("searching in shop goods");

				$sql_query = "SELECT * FROM `ksh_shop_goods`
					WHERE 
					`name` LIKE '%".mysql_real_escape_string($search_string)."%' OR
					`commentary` LIKE '%".mysql_real_escape_string($search_string)."%'
					";
				$result = exec_query($sql_query);
				$if_show_heading = 1;
				while ($row = mysql_fetch_array($result))
				{
					if ($if_show_heading)
					{
						$content['results'][$i]['heading'] = "Товары";
						$if_show_heading = 0;
					}
	
					$content['results'][$i]['module'] = "shop";
					$content['results'][$i]['action'] = "view_good";
					$content['results'][$i]['id'] = stripslashes($row['id']);
					$content['results'][$i]['name'] = "good:".stripslashes($row['id']);
					$content['results'][$i]['ext'] = "";
					$content['results'][$i]['title'] = stripslashes($row['name']);


					$content['results'][$i]['inst_root'] = $content['inst_root'];
					$content['results'][$i]['site_url'] = $content['site_url'];
					debug("result ".$i.":", 2);
					dump($content['results'][$i]);
					$i++;
				}
				mysql_free_result($result);
			}
        }
    }
    else
        debug ("have nothing to search!");

    debug ("*** search_main ***");
    return $content;
}

function search_default_action()
{

        debug("<br>=== mod: search ===");

        if (isset($_GET['action']))
        {
                debug ("*** action: ".$_GET['action']);
                switch ($_GET['action'])
                {
                        default:
                                $content .= gen_content("search", "main", search_main());
                        break;
                }
        }

        else
        {
                debug ("*** action: default");
                $content = gen_content("search", "main", search_main());
        }

        debug("=== end: mod: search ===<br>");
        return $content;

}

?>
