<?php

function users_groups_update()
{
	global $user;
	global $config;
	debug ("*** users_groups_update ***");

	$groups = array();

	$client =new xmlrpc_client("/modules/users/xmlrpcserver.php", $config['bbcpanel']['bbcpanel_domain']);
	$message =new xmlrpcmsg('getgroups', array(
		new xmlrpcval($config['bbcpanel']['password'], "string")
		));
	$response =$client->send($message);

	if (!$response ->faultCode(  ))
	{
		// First clean up tables
		$sql_query = "DELETE FROM `ksh_users_groups`";
		exec_query($sql_query);

		// Get categories from response
		$v=$response->value();

		write_file_log("users_groups_update: server answered\n");
		write_file_log("users_groups_update server response:\n".$response->serialize(), 2);
		
		for($a=0; $a<$v->arraysize(  ); $a++)
		{
			$z=$v->arraymem($a);

			$struct_id = $z -> structmem("id");
			$struct_title = $z -> structmem("title");

			$group['id'] = $struct_id->scalarval();
			$group['title'] = $struct_title->scalarval();

			$sql_query = "INSERT INTO `ksh_users_groups` (`id`, `title`) VALUES (
				'".mysql_real_escape_string($group['id'])."',
				'".mysql_real_escape_string($group['title'])."'
				)";
			write_file_log("users_groups_update: ".$sql_query);
			$result = exec_query($sql_query);
		}
	}
	else
	    write_file_log("users_groups_update: Problem code: " . $response->faultCode(  ) . " Reason: '" .$response->faultString(  )."'");

	debug ("*** end: users_groups_update ***");
	return 1;
}

function users_users_update()
{
	global $user;
	global $config;
	debug ("*** users_users_update ***");

	$groups = array();

	$client =new xmlrpc_client("/modules/users/xmlrpcserver.php", $config['bbcpanel']['bbcpanel_domain']);
	$message =new xmlrpcmsg('getusers', array(
		new xmlrpcval($config['bbcpanel']['password'], "string")
		));
	$response =$client->send($message);

	if (!$response ->faultCode(  ))
	{
		// First clean up tables
		$sql_query = "DELETE FROM `ksh_users`";
		exec_query($sql_query);

		// Get categories from response
		$v=$response->value();

		write_file_log("users_users_update: server answered\n");
		write_file_log("users_users_update server response:\n".$response->serialize(), 2);
		
		for($a=0; $a<$v->arraysize(  ); $a++)
		{
			$z=$v->arraymem($a);

			$struct_id = $z -> structmem("id");
			$struct_login = $z -> structmem("login");
			$struct_name = $z -> structmem("name");
			$struct_password = $z -> structmem("password");
			$struct_email = $z -> structmem("email");
			$struct_group = $z -> structmem("group");

			$user['id'] = $struct_id->scalarval();
			$user['login'] = $struct_login->scalarval();
			$user['name'] = $struct_name->scalarval();
			$user['password'] = $struct_password->scalarval();
			$user['email'] = $struct_email->scalarval();
			$user['group'] = $struct_group->scalarval();

			write_file_log("users_users_update: id: ".$user['id'].", login: ".$user['login']);

			$sql_query = "INSERT INTO `ksh_users` (`id`, `login`, `name`, `password`, `email`, `group`) VALUES (
				'".mysql_real_escape_string($user['id'])."',
				'".mysql_real_escape_string($user['login'])."',
				'".mysql_real_escape_string($user['name'])."',
				'".mysql_real_escape_string($user['password'])."',
				'".mysql_real_escape_string($user['email'])."',
				'".mysql_real_escape_string($user['group'])."'
				)";
			$result = exec_query($sql_query);
		}
	}
	else
	    write_file_log("users_users_update: Problem code: " . $response->faultCode(  ) . " Reason: '" .$response->faultString(  )."'");

	debug ("*** end: users_users_update ***");
	return 1;
}

?>
