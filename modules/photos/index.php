<?php

// Base functions of the "photos" module


include_once ("db.php");
include_once ("categories.php");
include_once ("galleries.php");
include_once ("photos.php");

function photos_admin()
{
	debug ("*** photos_admin ***");
	$content = array(
		'content' => ''
	);
	debug ("*** end: photos_admin ***");
    return $content;
}

function photos_frontpage()
{
	debug ("*** photos_frontpage ***");
        global $user;
        global $config;
		$content = array(
			'content' => '',
			'categories' => ''
		);
		$i = 0;
       
        $categories = exec_query ("SELECT * FROM ksh_photos_categories");
        while ($category = mysql_fetch_array($categories))
        {
			$content['categories'][$i]['id'] = stripslashes($category['id']);
			$content['categories'][$i]['name'] = stripslashes($category['name']);
			$content['categories'][$i]['title'] = stripslashes($category['title']);
			if (1 == $user['id'])
				$content['categories'][$i]['edit_link'] =  "<a href=\"/index.php?module=photos&action=category_edit&category=".$category['id']."\">Редактировать</a>";
			else
				$content['categories'][$i]['edit_link'] = "";
        	
            $content['categories'][$i]['galleries'] = "";
            
            $galleries = exec_query ("SELECT * FROM ksh_photos_galleries WHERE category='".$category['id']."'");
            while ($gallery = mysql_fetch_array($galleries))
            {
            	 
            	$content['categories'][$i]['galleries'] .= "<h2>".stripslashes($gallery['name'])."</h2>";
                $content['categories'][$i]['galleries'] .= stripslashes($gallery['descr']);
                $photos = exec_query("SELECT * FROM ksh_photos WHERE gallery='".$gallery['id']."'");
                while ($photo = mysql_fetch_array($photos))
                {
                	$content['categories'][$i]['galleries'] .= "<a href=\"".stripslashes($photo['image'])."\"><img src=\"".stripslashes($photo['thumb'])."\"></a>";
                }
                mysql_free_result($photos); 
                
            }
            mysql_free_result($galleries);
            
            $i++;
        }
        mysql_free_result($categories);
        
    debug ("*** end: photos_frontpage");
    return $content;
}


function photos_default_action()
{
        global $user;
        $content = "";
        $nav_string = "";

        $content .= $nav_string;

        debug("<br>=== mod: photos ===");

        if (isset($_GET['action']))
        {
                debug ("*** action: ".$_GET['action']);
                switch ($_GET['action'])
                {
                        default:
                                $content .= gen_content("photos", "frontpage", photos_frontpage());
                        break;

                        case "admin":
                                $content .= gen_content("photos", "admin", photos_admin());
                        break;

                        case "install_tables":
                                $content .= gen_content("photos", "install_tables", photos_install_tables());
                        break;

                        case "drop_tables":
                                $content .= gen_content("photos", "drop_tables", photos_drop_tables());
                        break;

						case "update_tables":
                                $content .= gen_content("photos", "update_tables", photos_update_tables());
                        break;

                        case "view_categories":
                                $content .= gen_content("photos", "categories_view", photos_categories_view());
                        break;

                        case "view_galleries":
                                $content .= gen_content("photos", "galleries_view", photos_galleries_view());
                        break;

                        case "view_gallery":
                                $content .= gen_content("photos", "gallery_view", photos_gallery_view());
                        break;

                        case "view_galleries_by_category":
                                $content .= gen_content("photos", "galleries_view_by_category", photos_galleries_view_by_category());
                        break;

                        case "add_category":
                                $content .= gen_content("photos", "categories_add", photos_categories_add());
                        break;

                        case "add_gallery":
                                $content .= gen_content("photos", "galleries_add", photos_galleries_add());
                        break;

                        case "add":
                                $content .= gen_content("photos", "add", photos_add());
                        break;

						case "del":
                                $content .= gen_content("photos", "del", photos_del());
                        break;

						case "edit":
                                $content .= gen_content("photos", "edit", photos_edit());
                        break;

						case "view":
							$content .= gen_content("photos", "view", photos_view());
						break;

						case "category_edit":
                                $content .= gen_content("photos", "categories_edit", photos_categories_edit());
                        break;

						case "gallery_edit":
                                $content .= gen_content("photos", "galleries_edit", photos_galleries_edit());
                        break;
                }
        }

        else
        {
                debug ("*** action: default");
                $content = gen_content("photos", "frontpage", photos_frontpage());
        }

        debug("=== end: mod: photos ===<br>");
        return $content;

}

?>
