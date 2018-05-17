<?php

// Base functions of the templater module

debug ("templater module included", 2);

include_once ($config['modules']['location']."templater/config.php");

$config_file = $config['base']['doc_root']."/config/templater.php";
if (file_exists($config_file))
	include($config_file);

function templater_find_template($module, $template)
{
	global $user;
	global $config;

	debug ("=== templater_find_template ===");

	debug("module: ".$module);
	debug("template: ".$template);

	$tpl_file = "";

	debug ("trying base module template");
	$new_tpl_file = $config['modules']['location']."base/templates/".$template.".php";
	debug ($new_tpl_file);
	if (file_exists($new_tpl_file))
	{
		debug ("exists, switching to it");
		$tpl_file = $new_tpl_file;
	}
	else
		debug ("doesn't exist");

	debug ("trying module template");
	$new_tpl_file = $config['modules']['location'].$module."/templates/".$template.".php";
	debug ($new_tpl_file);
	if (file_exists($new_tpl_file))
	{
		debug ("exists, switching to it");
		$tpl_file = $new_tpl_file;
	}
	else
		debug ("doesn't exist");

	debug ("trying theme-specific template");
	$new_tpl_file = $config['themes']['dir'].$config['themes']['current']."/templates/".$module."/".$template.".php";
	debug ($new_tpl_file);
	if (file_exists($new_tpl_file))
	{
		debug ("exists, switching to it");
		$tpl_file = $new_tpl_file;
	}
	else
		debug ("doesn't exist");


	debug ("template file: ".$tpl_file);

	debug ("=== end: templater_find_template ===");
	return ($tpl_file);
}

function gen_content($module, $template, $content)
{
    global $mods_dir;
	global $config;

	$tpl_file = "";
	$tpl = "";
	$if_tpl_file_exists = 0;
	$list_tpl_file = "";
	$list_tpl = "";
	$if_list_tpl_file_exists = 0;
	$list = "";


    debug ("=== mod: templater; fn: gen_content ===");

    debug ("; determining template file to use");

	debug ("beginning from the system-wide default template");
	$tpl_file = $config['modules']['location']."base/templates/default.php";

	$tpl_file = templater_find_template($module, $template);

	debug ("tpl_file: ".$tpl_file);

    debug ("; end: determining template file to use");

	if (file_exists($tpl_file))
	{
    	debug ("template file exists, proceeding normal operations");
        $tpl = file_get_contents ($tpl_file);

		debug ("; proceeding lists");
		debug("content: ", 2);
		dump($content);
        foreach ($content as $k => $v)
        {
	    	if (is_array($v))
	    	{
				debug ("> > > got a list in ".$k.", ".count($v)." elements", 2);
				foreach ($v as $v_key => $v_value)
				{
					debug ("in ".$v_key, 2);
					foreach ($v_value as $v_value_key => $v_value_value) debug ($v_value_key.":".$v_value_value, 2);
				}
				$tpl = str_replace ("#".$k."#", templater_list_proceed($k, $v, $module, $tpl), $tpl);
	    	}
	    	else
	    	{
				debug ("got casual data", 2);
	            debug ($k.":".$v, 2);
				$tpl = str_replace ("#".$k."#", $v, $tpl);
	    	}
        }
		debug("; end: proceeding lists");

		debug ("cleaning empty vars");
		$tpl = preg_replace("/#([[:alnum:]_]+)#/i", "", $tpl);

		debug ("; catching hooks");
		$tpl = templater_catch_hooks($tpl);
        debug ("; end: catching hooks");

		debug ("; proceeding logical structure");
        $tpl = templater_logic($tpl, $content);
        debug ("; end: proceeding logical structure");
		$pattern="/\{\{([a-z0-9\_]+:)\}\}/i";
        if (preg_match_all($pattern, $tpl, $dynamic_content))
        {
            debug ("dynamic content exists");
			dump($dynamic_content);

            foreach ($dynamic_content[1] as $k => $v)
            {
                debug ("dynamic content ".$k.":".$v, 2);

	            $dc = explode(":", $v);
	            $dc[0] = str_replace("{", "", $dc[0]);
	            $dc[1] = $dc[1];
				if (isset($dc[2]))
		            $dc[2] = str_replace("}", "", $dc[2]);
				else
					$dc[2] = "";
	            debug($dc[0].":".$dc[1].":".$dc[2], 2);
	            debug ("including module ".$dc[0]);
	            include_once ($mods_dir."/".$dc[0]."/index.php");
	            debug ("dyn content 0: ".$v, 2);
	            debug ("dc 1: ".$dc[1], 2);
	            debug ("dc 2: ".$dc[2], 2 );
				$f_name = $dc[0]."_".$dc[1];
	            $new_tpl = str_replace ("{{".$v."}}", $f_name($dc[2]), $tpl);
	            debug ("changing template ".$tpl." on ".$new_tpl);
	            $tpl = $new_tpl;
			}
        }
		else
	        debug ("dynamic content doesn't exist");

	}
    else debug ("template file doesn't exist!");
    debug ("=== end: mod: templater; fn: gen_content ===");
    return $tpl;
}

function output ($content)
{
	global $config;
    global $user;
	global $template;
    debug ("=== mod: templater; fn: output ===");
    if (isset($_GET['page_template']))
    {
    	debug ("have page name in GET");
    	$page = $_GET['page_template'];
    }
	else if ("yes" == $config['themes']['admin'])
	{
		debug ("switching to admin mode, using admin page");
		$page = $config['themes']['admin_page'];
	}
    else
    {
    	debug ("don't have page name in GET, using config value");
        $page = $config['themes']['page_tpl'];
    }

	debug ("page template: ".$page);
	$page_path = $config['themes']['dir'].$config['themes']['current']."/pages/".$page.".php";
	debug ("page path: ".$page_path);

	debug("page_title: ", 2);
	dump($config['themes']['page_title']);
	if (is_array($config['themes']['page_title']))
	{
		if (!isset($config['themes']['page_title']['element']) || "" == $config['themes']['page_title']['element'])
			if (isset($config['themes']['page_title']['action']) || "" != $config['themes']['page_title']['action'])
				$config['themes']['page_title']['element'] = $config['themes']['page_title']['action'];

		if ("yes" == $config['themes']['categories_title_reverse'])
		{
			debug("reversing categories title");
			$config['themes']['page_title']['categories_title'] = array_reverse($config['themes']['page_title']['categories_title']);
		}
		$template['title'] = gen_content("base", "page_title", $config['themes']['page_title']);
	}


	if (in_array("themes", $config['modules']['installed']))
	{
		$sql_query = "SELECT * FROM `ksh_themes_tparts`";
		$result = exec_query($sql_query);
		if ($result)
		{
			while ($row = mysql_fetch_array($result))
			{
				$title = stripslashes($row['title']);
				$tpart = stripslashes($row['tpart']);
				$template[$title] = $tpart;
			}
			mysql_free_result($result);
		}
	}

	debug("template:", 2);
	dump($template);
	foreach ($template as $idx => $tpl)
	{
		foreach ($template as $tname => $tpart)
		{
			if ($idx != $tname)
			{
				debug("searching for ".$tname." in ".$idx);
				debug($idx.": ".$template[$idx], 2);
				$template[$idx] = str_replace ("#".$tname."#", $tpart, $template[$idx]);
				debug($idx.": ".$template[$idx], 2);
				dump($template);
			}
		}
	}
	debug("template:", 2);
	dump($template);

    include_once ($page_path);

    debug ("<br>=== end: mod: templater; fn: output ===");

    return 1;
}

function templater_default_action()
{
    return 1;
}


function templater_logic($tpl, $content)
{
	debug ("*** templater_logic ***");
	global $config;

	$pattern = "/\{\{if:([a-z0-9_]+):([^{^}]*)\}\}/i";
    if(preg_match_all($pattern, $tpl, $branches))
    {
    	debug ("there are logic!", 2);

		dump($branches);

		foreach($branches[0] as $branch_idx => $branch_text)
		{
			debug("; branch_idx: ".$branch_idx);
			debug("branch_text: ".$branch_text);
			$condition_name = $branches[1][$branch_idx];
			if (isset($content[$condition_name]))
				$condition_trigger = $content[$condition_name];
			else
				$condition_trigger = "";
			$condition_text = $branches[2][$branch_idx];
			debug("condition_name: ".$condition_name);
			if (is_array($condition_trigger))
			{
				debug("condition_trigger:");
				dump($condition_trigger);
			}
			else
				debug("condition_trigger: ".$condition_trigger);
			debug("condition_text: ".$condition_text);

	        if  (("" != $condition_trigger) &&
				!(
					("0" == $condition_trigger)
					&& ("no" == $config['templater']['show_null_values'])
				))
	        {
		       	debug ("outputting", 2);
	            $tpl = str_replace ($branch_text, $condition_text, $tpl);
	        }
	        else
	        {
	        	debug ("not outputting", 2);
	            $tpl = str_replace ($branch_text, "", $tpl);
	        }
		}
    }
	else
	    debug ("there are no logic", 2);

    debug ("*** end: templater_logic ***");
    return $tpl;
}

function templater_list_proceed($name, $data, $module, $template)
{
	debug ("*** templater_list_proceed ***");
	global $config;
	global $user;

	$list_tpl_file = "";
	$if_list_tpl_file_exists = 0;
	$tpl = "";
	$list = "";

	$list_tpl_file = $config['themes']['dir'].$config['themes']['current']."/templates/".$module."/list_".$name.".php";
    debug ("list template file: ".$list_tpl_file);
	if (file_exists($list_tpl_file))
    {
    	debug ("user list template file exists, using it");
		$if_list_tpl_file_exists = 1;
	}
	else
	{
		debug ("user list template file doesn't exist, trying to use default module template");
		$list_tpl_file = $config['modules']['location'].$module."/templates/list_".$name.".php";
		debug ("list template file: ".$list_tpl_file);
		if (file_exists($list_tpl_file))
		{
			debug ("module default list template exist, using it");
			$if_list_tpl_file_exists = 1;
		}
		else
		{
			debug ("module default list template doesn't exist, using base module template");
			$list_tpl_file = $config['modules']['location']."base"."/templates/list_".$name.".php";
			debug ("list template file: ".$list_tpl_file);
			if (file_exists($list_tpl_file))
			{
				debug ("base module list template exist, using it");
				$if_list_tpl_file_exists = 1;
			}
			else
			{
				debug ("base module list template doesn't exist, using no template");
				$if_list_tpl_file_exists = 0;
			}
		}
	}
	if ($if_list_tpl_file_exists)
	{
		debug ("list template file exist, proceeding it");
		foreach ($data as $idx => $piece)
		{
			debug ("list idx: ".$idx, 2);
			$list_tpl = file_get_contents ($list_tpl_file);
            debug ("; proceeding logical structure", 2);
	        $list_tpl = templater_logic($list_tpl, $piece);
	        debug ("; end: proceeding logical structure", 2);

			debug ("original list data: ".$list_tpl, 2);
			foreach ($piece as $list_category => $list_data)
			{
				debug ($list_category.":".$list_data, 2);
				$list_tpl = str_replace ("#".$list_category."#", $list_data, $list_tpl);
				debug ("list data: ".$list_tpl, 2);
			}
			debug ("final list data: ".$list_tpl, 2);
			$list .= $list_tpl;
		}
		debug ("done proceeding list template file");

	}
	else
	{
		debug ("list template file doesn't exist, parent function must ignore data and strip vars from parent template");
	}
	debug ("*** end: templater_list_proceed ***");
	return $list;

}

function templater_catch_hooks($tpl)
{
	global $user;
	global $config;

	debug ("*** templater_catch_hooks ***");

	$catch_strings = array(
		"/\{\{hook:([a-z0-9]+)\}\}/i",
		"/\{\{hook:([a-z0-9]+):([a-z0-9_]+)\}\}/i",
		"/\{\{hook:([a-z0-9]+):([a-z0-9_]+):([a-z0-9]*)\}\}/i"
	);

	foreach($catch_strings as $catch_string_idx => $catch_string)
		if (preg_match_all($catch_string, $tpl, $hooks_catched))
		{
			debug("got hook");
			dump($hooks_catched);

			if (isset($hook_module))
				unset($hook_module);
			if (isset($hook_parameter))
				unset($hook_parameter);
			if (isset($hook_value))
				unset($hook_value);

			if (isset($hooks_catched[1][0]))
				$hook_module = $hooks_catched[1][0];
			if (isset($hooks_catched[2][0]))
				$hook_parameter = $hooks_catched[2][0];
			if (isset($hooks_catched[3][0]))
				$hook_value = $hooks_catched[3][0];

			$hook_function = $hook_module."_hook";

			debug("module: ".$hook_module);
			if (isset($hook_parameter))
				debug("parameter: ".$hook_parameter);
			if (isset($hook_value))
				debug("value: ".$hook_value);

			include_once ($config['modules']['location'].$hook_module."/index.php");

			if (isset($hook_value))
				$tpl = str_replace ("{{hook:".$hook_module.":".$hook_parameter.":".$hook_value."}}", $hook_function($hook_parameter, $hook_value), $tpl);
			else if (isset($hook_parameter))
				$tpl = str_replace ("{{hook:".$hook_module.":".$hook_parameter."}}", $hook_function($hook_parameter), $tpl);
			else if (isset($hook_module))
				$tpl = str_replace ("{{hook:".$hook_module."}}", $hook_function(), $tpl);
		}
		else
			debug ("got no hooks");


	debug ("*** end: templater_catch_hooks ***");

	return $tpl;

}

?>
