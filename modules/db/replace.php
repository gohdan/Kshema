<?php

// Replace functions of db module

function db_replace()
{
	debug ("*** db_replace ***");
	global $config;
    global $user;
    $content = array(
    	'content' => '',
		'result' => '',
		'search_string' => '',
		'replace_string' => '',
		'if_replace' => ''
    );
	$count = 0;
	

	if (1 == $user['id'])
	{
		debug ("user has admin rights");
		if (isset($_POST['search_string']))
		{
			$content['search_string'] = $_POST['search_string'];
			$sql_query = "SELECT count(*) FROM ".mysql_real_escape_string($_POST['search_table'])." WHERE ".mysql_real_escape_string($_POST['search_field'])." LIKE '%".mysql_real_escape_string($_POST['search_string'])."%'";
			$result = exec_query($sql_query);
			$count = mysql_result($result, 0, 0);
			mysql_free_result($result);
			$content['result'] .= "Найдено вхождений: ".$count."";
			
			if (($count > 0) && (isset($_POST['if_replace'])))
			{
				$sql_query = "SELECT id, ".mysql_real_escape_string($_POST['search_field'])." FROM ".mysql_real_escape_string($_POST['search_table'])." WHERE ".mysql_real_escape_string($_POST['search_field'])." LIKE '%".mysql_real_escape_string($_POST['search_string'])."%'";
				$result = exec_query($sql_query);
				while ($row = mysql_fetch_array($result))
				{
					$full_text = str_replace($_POST['search_string'], $_POST['replace_string'], stripslashes($row[$_POST['search_field']]));
					$sql_query = "UPDATE ".mysql_real_escape_string($_POST['search_table'])." SET ".mysql_real_escape_string($_POST['search_field'])." = '".mysql_real_escape_string($full_text)."' WHERE id='".$row['id']."'";
					debug ($sql_query);
					exec_query ($sql_query);
					
				}
				mysql_free_result($result);
				$content['result'] .= "Замена произведена успешно.";
			}
		}
		
		if (isset($_POST['replace_string']))
			$content['replace_string'] = $_POST['replace_string'];
		if (isset($_POST['if_replace']))
			$content['if_replace'] = " checked";
		if (isset($_POST['search_table']))
			$content['search_table'] = $_POST['search_table'];
		if (isset($_POST['search_field']))
			$content['search_field'] = $_POST['search_field'];
		
	}
	else
	{
		debug ("user doesn't have admin rights");
		$content['result'] .= "Пожалуйста, войдите на сайт как администратор";
	}
    
	debug ("*** end: db_replace ***");
    return $content;
}

?>