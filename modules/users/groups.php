<?php

// groups administration functions of the "users" module

function users_groups_add()
{
    debug ("*** users_groups_add ***");
    global $config;
    global $user;
	$content = array(
    	'content' => '',
        'result' => ''
    );
    
    debug ("user id: ".$user['id']);
    if (1 == $user['id'])
    {
        debug ("user is admin");
        if (isset($_POST['do_add']))
        {
            debug ("have data to add");
            if ("" != $_POST['title'])
            {
                debug ("group title isn't empty");
				if (!isset($_POST['redirect']))
					$_POST['redirect'] = "";
				$sql_query = "INSERT INTO `ksh_users_groups` (`title`, `redirect`) VALUES (
					'".db_escape($_POST['title'])."',
					'".db_escape($_POST['redirect'])."'
					)";
                exec_query($sql_query);
                $content['result'] .= "Группа добавлена";
            }
            else
            {
                debug ("group title is empty");
                $content['result'] .= "Пожалуйста, задайте название группы";
            }
        }
    }
    else
    {
        debug ("user isn't admin");
        $content['content'] = "Пожалуйста, войдите в систему как администратор";
    }

    debug ("*** end: users_groups_add ***");
    return $content;
}

function users_group_del()
{
    debug ("*** users_group_del ***");
    global $config;
    global $user;
    $content = array(
    	'content' => '',
        'id' => '',
        'title' => ''
    );

    if (1 == $user['id'])
    {
        debug ("user has admin rights");
		if (isset($_GET['group']))
			$id = $_GET['group'];
		else if (isset($_GET['element']))
			$id = $_GET['element'];
		else
			$id = 0;

		$content['id'] = $id;

		$sql_query = "SELECT `title` FROM `ksh_users_groups` WHERE id='".db_escape($id)."'";
		$result = exec_query($sql_query);
		$row = mysqli_fetch_array($result);
		mysqli_free_result($result);

		$content['title'] = stripslashes($row['title']);

    }
    else
    {
        debug ("user doesn't have admin rights!");
        $content['content'] .= "Пожалуйста, войдите в систему как администратор";
    }

    debug ("*** end: users_group_del ***");
    return $content;
}

function users_groups_view()
{
    debug ("*** users_groups_view ***");
    global $config;
    global $user;
	$content = array (
    	'content' => '',
        'groups' => array()
    );
    $i = 0;

	$priv = new Privileges();

    if ($priv->has("users", "admin", "write"))
    {
        debug ("user is admin");
		$content['show_admin_link'] = "yes";

        if (isset($_POST['do_del']))
        {
            debug ("deleting group ".$_POST['id']);
			$sql_query = "DELETE FROM `ksh_users_groups` WHERE `id` = '".db_escape($_POST['id'])."'";
            exec_query ($sql_query);
        }

        $result = exec_query("SELECT * FROM `ksh_users_groups`");
      	while ($group = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
	       	$content['groups'][$i]['id'] = $group['id'];
            $content['groups'][$i]['name'] = $group['name'];
            $content['groups'][$i]['title'] = $group['title'];
			$i++;
        }
        mysqli_free_result($result);
    }
    else
    {
        debug ("user isn't admin");
        $content['content'] = "Пожалуйста, войдите в систему как администратор";
    }

    debug ("*** end: users_groups_view ***");
    return $content;
}

function users_group_edit()
{
    debug ("*** users_group_edit ***");
    global $config;
    global $user;
    $content = array(
    	'content' => '',
        'result' => '',
        'group_id' => '',
        'name' => '',
        'title' => ''
    );

    if (isset($_GET['group']))
		$group_id = $_GET['group'];
    else if (isset($_POST['id']))
		$group_id = $_POST['id'];
	else if (isset($_GET['element']))
		$group_id = $_GET['element'];
    else
		$group_id = 0;
    debug ("group id: ".$group_id);

    debug ("user id: ".$user['id']);
    if (1 == $user['id'])
    {
        debug ("user is admin");
        if (isset($_POST['do_update']))
        {
            debug ("have data to update");
            if ("" != $_POST['title'])
            {
                debug ("group title isn't empty");
				$sql_query = "UPDATE `ksh_users_groups` SET
					`title` = '".db_escape($_POST['title'])."',
					`redirect` = '".db_escape($_POST['redirect'])."'
					WHERE `id` = '".db_escape($group_id)."'";
                exec_query($sql_query);
                $content['result'] .= "Изменения записаны";
            }
            else
            {
                debug ("group title is empty");
                $content['result'] .= "Пожалуйста, задайте название группы";
            }
        }
        else
            debug ("no data to update");


		$sql_query = "SELECT * FROM `ksh_users_groups` WHERE `id` = '".db_escape($group_id)."'";
		$result = exec_query($sql_query);
        $group = mysqli_fetch_array($result);
        mysqli_free_result($result);
        $content['group_id'] = stripslashes($group['id']);
        $content['name'] = stripslashes($group['name']);
        $content['title'] = stripslashes($group['title']);
        $content['redirect'] = stripslashes($group['redirect']);
    }
    else
    {
        debug ("user isn't admin");
        $content['content'] = "Пожалуйста, войдите в систему как администратор";
    }

    debug ("*** end: users_group_edit ***");
    return $content;
}

?>
