<?php

// Base functions of the "frontpage" module

function frontpage_default()
{
	global $config;
        debug ("*** frontpage_default");
		$config['modules']['current_id'] = 1;

        $content['content'] = "";

        debug ("*** end: frontpage_default");

        return $content;
}


function frontpage_default_action()
{
	global $config;

        $content['content'] = "";

        debug("<br>=== mod: frontpage ===");

        if (isset($_GET['action']))
        {
                debug ("*** action: ".$_GET['action']);
                switch ($_GET['action'])
                {
                        default:
                                $config['themes']['page_tpl'] = "frontpage";
								$content = gen_content("frontpage", "default", frontpage_default());
                        break;
                }
        }

        else
        {
                debug ("*** action: default");
                $config['themes']['page_tpl'] = "frontpage";
				$content = gen_content("frontpage", "default", frontpage_default());
        }

        debug("=== end: mod: frontpage ===<br>");
        return $content;

}

?>
