<?php

// Base functions of the "banners" module

include_once ("db.php");
include_once ("categories.php");
include_once ("banners.php");

function banners_insert_by_page()
{
	debug ("*** banners_insert_by_page ***");
	global $user;
	global $config;
	$content = array(
		'result' => '',
		'content' => '',
		'image' => ''
	);
	if (1 == $user['id'])
	{
		debug ("user is admin");
	}
	else
	{
		debug ("user isn't admin");
		$content['content'] = "Пожалуйста, войдите как администратор";
	}

	$content['image'] = $config['pages']['page_name'].".jpg";

	debug ("*** end:banners_insert_by_page ***");
	return $content;
}

function banners_admin()
{
        $content['content'] = "";
        return $content;
}

function banners_help()
{
	debug ("*** banners_help ***");
	global $user;
	global $config;
	$content['content'] = "";
	debug ("*** end: banners_help ***");
	return $content;
}

function banners_frontpage()
{
    debug ("*** banners_frontpage ***");
	$content = array (

	);
    debug ("*** end: news_frontpage");
    return $content;
}



function banners_default_action()
{
		global $config;
        global $user;
        $content = "";


        debug("<br>=== mod: banners ===");

        if (isset($_GET['action']))
        {
                debug ("*** action: ".$_GET['action']);
                switch ($_GET['action'])
                {
                        default:
                                //$content .= gen_content("banners", "frontpage", banners_frontpage());
                                $content .= gen_content("banners", "admin", banners_admin());
                        break;

                        case "admin":
                                $content .= gen_content("banners", "admin", banners_admin());
                        break;

                        case "help":
                                $content .= gen_content("banners", "help", banners_help());
                        break;

                        case "install_tables":
                                $content .= gen_content("banners", "install_tables", banners_install_tables());
                        break;

                        case "drop_tables":
                                $content .= gen_content("banners", "drop_tables", banners_drop_tables());
                        break;

                        case "update_tables":
                                $content .= gen_content("banners", "update_tables", banners_update_tables());
                        break;

                        case "view_categories":
                                $content .= gen_content("banners", "categories_view", banners_categories_view());
                        break;

                        case "add_category":
                                $content .= gen_content("banners", "categories_add", banners_categories_add());
                        break;

                        case "del_category":
                                $content .= gen_content("banners", "categories_del", banners_categories_del());
                        break;

                        case "add_banners":
                                $content .= gen_content("banners", "add", banners_add());
                        break;

                        case "view_by_category":
								$content_data = banners_view_by_category();
                                $content .= gen_content("banners", "view_by_category", $content_data);
                        break;

                        case "edit":
                                $content .= gen_content("banners", "edit", banners_edit());
                        break;

                        case "del":
                                $content .= gen_content("banners", "del", banners_del());
                        break;

                        case "view":
								$content_data = banners_view();
                                $content .= gen_content("banners", $config['banners']['banners_template'], $content_data);
                        break;

                        case "category_edit":
                                $content .= gen_content("banners", "categories_edit", banners_categories_edit());
                        break;
				}
        }

        else
        {
                debug ("*** action: default");
                //$content = gen_content("banners", "frontpage", banners_frontpage());
                $content = gen_content("banners", "admin", banners_admin());
	     }

        debug("=== end: mod: banners ===<br>");
        return $content;
}

?>
