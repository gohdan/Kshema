<?php

include_once("../../config.php");

ini_set('error_reporting', $config['base']['error_reporting']);
error_reporting($config['base']['error_reporting']);
if ($config['base']['error_reporting'])
	ini_set('display_errors', 1);
else
	ini_set('display_errors', 0);

include_once($config['base']['doc_root']."/modules/base/index.php");
include_once($config['base']['doc_root']."/modules/db/index.php");
if (in_array("bbcpanel", $config['modules']['installed']))
	include_once($config['base']['doc_root']."/modules/bbcpanel/index.php");
include_once($config['base']['doc_root']."/modules/users/xmlrpcclient.php");
include_once($config['base']['doc_root']."/libs/xmlrpc/xmlrpc.inc");
include_once($config['base']['doc_root']."/libs/xmlrpc/xmlrpc_wrappers.inc");
include_once($config['base']['doc_root']."/libs/xmlrpc/xmlrpcs.inc");
connect_2db ($config['db']['db_user'], $config['db']['db_password'], $config['db']['db_host'], $config['db']['db_name']);

	/**
	* Used to test usage of object methods in dispatch maps and in wrapper code
	*/
	class xmlrpc_server_methods_container
	{
		/**
		* Method used to test logging of php warnings generated by user functions.
		*/
		function phpwarninggenerator($m)
		{
			$a = $b; // this triggers a warning in E_ALL mode, since $b is undefined
			return new xmlrpcresp(new xmlrpcval(1, 'boolean'));
		}

	    /**
	     * Method used to testcatching of exceptions in the server.
	     */
	    function exceptiongenerator($m)
	    {
	        throw new Exception("it's just a test", 1);
	    }
	}



	/* === users_update === */
	$users_update_sig = array(array($xmlrpcArray, $xmlrpcString));
	$users_update_doc = "Forces users update";
	function users_update($m)
	{
		global $config;
		$v = $m -> getParam(0);
		$password = $v -> scalarval();
		$result = 1;
		if ($password == $config['bbcpanel']['password'])
		{
			write_file_log("users_update: password matches");
			users_groups_update();
			users_users_update();
		}
		else
		{
			write_file_log("users_update: password doesn't match");
			$result = "";
		}
		return new xmlrpcresp(new xmlrpcval($result));
	}
	/* === end: users_update === */

	/* === getgroups === */

	$getgroups_sig=array(array($xmlrpcArray, $xmlrpcString));
	$getgroups_doc='Returns groups';
	function getgroups($m)
	{
		global $config;
		global $xmlrpcArray;

		$v = $m -> getParam(0);
		$password = $v -> scalarval();

		if ($password == $config['bbcpanel']['password'])
		{
			write_file_log("getgroups: password matches");
			$groups = new xmlrpcval();

			$sql_query = "SELECT * FROM `ksh_users_groups`";
			$result = exec_query($sql_query);
			while ($row = mysql_fetch_array($result))
			{
				foreach($row as $k => $v)
					$row[$k] = stripslashes($v);

				write_file_log("getgroups: id: ".$row['id'].", title: ".$row['title']);

				$t = array();
				$t[] = new xmlrpcval(
					array(
						"id" => new xmlrpcval($row['id'], "string"),
						"title" => new xmlrpcval($row['title'], "string")
					), "struct");
				$groups->addArray($t);

			}
			mysql_free_result($result);

		}
		else
		{
			write_file_log("password doesn't match");
			$groups = array();
		}

		
		$r = new xmlrpcresp($groups);
		return $r;
	}

	/* === end: getgroups === */


	/* === getusers === */

	$getusers_sig=array(array($xmlrpcArray, $xmlrpcString));
	$getusers_doc='Returns users';
	function getusers($m)
	{
		global $config;
		global $xmlrpcArray;

		$v = $m -> getParam(0);
		$password = $v -> scalarval();

		if ($password == $config['bbcpanel']['password'])
		{
			write_file_log("getusers: password matches");
			$groups = new xmlrpcval();

			$sql_query = "SELECT * FROM `ksh_users`";
			$result = exec_query($sql_query);
			while ($row = mysql_fetch_array($result))
			{
				foreach($row as $k => $v)
					$row[$k] = stripslashes($v);

				write_file_log("getusers: id: ".$row['id'].", login: ".$row['login']);

				$t = array();
				$t[] = new xmlrpcval(
					array(
						"id" => new xmlrpcval($row['id'], "string"),
						"login" => new xmlrpcval($row['login'], "string"),
						"name" => new xmlrpcval($row['name'], "string"),
						"password" => new xmlrpcval($row['password'], "string"),
						"email" => new xmlrpcval($row['email'], "string"),
						"group" => new xmlrpcval($row['group'], "string")
					), "struct");
				$groups->addArray($t);

			}
			mysql_free_result($result);

		}
		else
		{
			write_file_log("password doesn't match");
			$groups = array();
		}

		
		$r = new xmlrpcresp($groups);
		return $r;
	}

	/* === end: getusers === */

	$o=new xmlrpc_server_methods_container;
	$a=array(
		"users_update" => array(
			"function" => "users_update",
			"signature" => $users_update_sig,
			"docstring" => $users_update_doc
		),
		"getgroups" => array(
			"function" => "getgroups",
			"signature" => $getgroups_sig,
			"docstring" => $getgroups_doc
		),
		"getusers" => array(
			"function" => "getusers",
			"signature" => $getusers_sig,
			"docstring" => $getusers_doc
		)
	);

	$s=new xmlrpc_server($a, false);
	$s->setdebug(3);
	$s->compress_response = true;


	$s->service();

?>
