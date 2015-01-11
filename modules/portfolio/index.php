<?php

// Base functions of the "portfolio" module


include_once ("db.php");
include_once ("categories.php");
include_once ("portfolio.php");


function portfolio_admin()
{
	debug ("*** portfolio_admin ***");
	global $config;
	global $user;
	$content = array (
		'content' => '',
		'heading' => ''
	);
	$content['heading'] = "Администрирование новостей";
	debug ("*** end: portfolio_admin ***");
	return $content;
}

function portfolio_help()
{
	debug ("*** portfolio_help ***");
	global $config;
	global $user;
	$content['content'] = "";
	debug ("*** end: portfolio_help ***");
	return $content;
}

function portfolio_frontpage()
{
    debug ("*** portfolio_frontpage ***");
    global $config;
    global $user;
	global $page_title;
    $content = array(
    	'content' => '',
        'portfolio' => '',
        'admin_link' => '',
        'result' => ''
    );

    debug ("*** end: portfolio_frontpage");
    return $content;
}


function portfolio_default_action()
{
	global $config;
	global $user;

	debug("<br>=== mod: portfolio ===");

	$content = "";

	if (isset($config['portfolio']['page_tpl']) && "" != $config['portfolio']['page_tpl'])
		$config['themes']['page_tpl'] = $config['portfolio']['page_tpl'];

	if (isset($config['portfolio']['menu_tpl']) && "" != $config['portfolio']['menu_tpl'])
		$config['themes']['menu_tpl'] = $config['portfolio']['menu_tpl'];
	

        if (isset($_GET['action']))
        {
                debug ("*** action: ".$_GET['action']);
                switch ($_GET['action'])
                {
                        default:
                                $content .= gen_content("portfolio", "frontpage", portfolio_frontpage());
                        break;

                        case "admin":
                                $content .= gen_content("portfolio", "admin", portfolio_admin());
                        break;

                        case "help":
                                $content .= gen_content("portfolio", "help", portfolio_help());
                        break;

                        case "install_tables":
                                $content .= gen_content("portfolio", "install_tables", portfolio_install_tables());
                        break;

                        case "drop_tables":
                                $content .= gen_content("portfolio", "drop_tables", portfolio_drop_tables());
                        break;

                        case "update_tables":
                                $content .= gen_content("portfolio", "update_tables", portfolio_update_tables());
                        break;

                        case "view_categories":
                                $content .= gen_content("portfolio", "categories_view", portfolio_categories_view());
                        break;

                        case "add_category":
                                $content .= gen_content("portfolio", "categories_add", portfolio_categories_add());
                        break;

                        case "del_category":
                                $content .= gen_content("portfolio", "categories_del", portfolio_categories_del());
                        break;

                        case "add_portfolio":
                                $content .= gen_content("portfolio", "add", portfolio_add());
                        break;

                        case "view_by_category":
								$content_data = portfolio_view_by_category();
                                $content .= gen_content("portfolio", $config['portfolio']['category_template'], $content_data);
                        break;

                        case "edit":
                                $content .= gen_content("portfolio", "edit", portfolio_edit());
                        break;

                        case "del":
                                $content .= gen_content("portfolio", "del", portfolio_del());
                        break;

                        case "view":
								$content_data = portfolio_view();
                                $content .= gen_content("portfolio", $config['portfolio']['portfolio_template'], $content_data);
                        break;

                        case "category_edit":
                                $content .= gen_content("portfolio", "categories_edit", portfolio_categories_edit());
                        break;

                        case "view_all":
								$content_data = portfolio_view_all();
                                $content .= gen_content("portfolio", "view_all", $content_data);
                        break;

                }
        }

        else
        {
                debug ("*** action: default");
                $content = gen_content("portfolio", "frontpage", portfolio_frontpage());
        }

        debug("=== end: mod: portfolio ===<br>");
        return $content;

}

?>

