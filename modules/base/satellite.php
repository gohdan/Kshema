<?php

class Satellite
{

var $id;
var $table;
var $url;
var $instroot;

function Satellite()
{
	global $user;
	global $config;
	debug("*** Satellite: constructor ***");

	$this -> table = $config['satellite']['table'];
	$this -> url = $this -> get_url();

	debug("*** end: Satellite: constructor ***");
}

function get_state()
{
	global $user;
	global $config;
	debug("*** Satellite: get_state ***");

	$sat_modules = array();
	$state = 0;

	$client =new xmlrpc_client($this -> get_instroot()."/modules/base/xmlrpcserver.php", $this -> get_url());
	$message =new xmlrpcmsg('get_state', array(
		new xmlrpcval($config['bbcpanel']['password'])
	));
	$response =$client->send($message);

	if (!$response ->faultCode(  ))
	{
		debug("Ответ XMLRPC сервера: ".htmlentities($response->serialize()));
		$state = 1;
	}
	else
	    debug("Проблема: Код: " . $response->faultCode(  ) . " Причина '" .$response->faultString(  )."'");
		
	debug("*** end: Satellite: get_state ***");
	return $state;

}

function get_open_modules()
{
	global $user;
	global $config;
	debug("*** Satellite: get_open_modules ***");

	$sat_modules = array();

	$client =new xmlrpc_client($this -> get_instroot()."/modules/base/xmlrpcserver.php", $this -> get_url());
	$message =new xmlrpcmsg('get_open_modules', array(
		new xmlrpcval($config['bbcpanel']['password'])
	));
	$response =$client->send($message);

	if (!$response ->faultCode(  ))
	{
		debug("Ответ XMLRPC сервера: ".htmlentities($response->serialize()));

		$v=$response->value();

		for($a = 0; $a < $v -> arraysize(); $a++)
		{
			$z = $v -> arraymem($a);

			$struct_name = $z -> structmem("name");

			$sat_modules[$a]['id'] = $this -> id;
			$sat_modules[$a]['name'] = $struct_name->scalarval();
			$sat_modules[$a]['title'] = modules_get_title($sat_modules[$a]['name']);
			debug("open module: ".$sat_modules[$a]['name']);
		}
	}
	else
	{
	    debug("Проблема: Код: " . $response->faultCode(  ) . " Причина '" .$response->faultString(  )."'");
		debug("Ответ XMLRPC сервера: ".htmlentities($response->serialize()));
	}
		
	debug("*** end: Satellite: get_open_modules ***");
	return $sat_modules;
}

function get_url()
{
	global $user;
	global $config;
	debug ("*** Satellite: get_url ***");
	$url = "";
	debug("table: ".$this -> table);
	debug("id: ".$this -> id);


	if ($this -> id)
	{
		$sql_query = "SELECT `url` FROM `".mysql_real_escape_string($this -> table)."`
			WHERE `id` = '".mysql_real_escape_string($this -> id)."'";
		$result = exec_query($sql_query);
		$row = mysql_fetch_array($result);
		mysql_free_result($result);
		$url = stripslashes($row['url']);

		if ("http://" == substr($url, 0, 7))
			$url = substr($url, 7);

		$url = rtrim($url, "/");
	}

	debug ("url: ".$url);

	debug ("*** end: Satellite: get_url ***");
	return $url;
}

function get_instroot()
{
	global $user;
	global $config;
	debug ("*** Satellite: get_instroot ***");
	$instroot = "";
	debug("table: ".$this -> table);
	debug("id: ".$this -> id);


	if ($this -> id)
	{
		$sql_query = "SELECT `instroot` FROM `".mysql_real_escape_string($this -> table)."`
			WHERE `id` = '".mysql_real_escape_string($this -> id)."'";
		$result = exec_query($sql_query);
		$row = mysql_fetch_array($result);
		mysql_free_result($result);
		$instroot = stripslashes($row['instroot']);

		if ("/" != substr($instroot, 0, 1))
			$instroot = "/".$instroot;

		$instroot = rtrim($instroot, "/");
	}

	debug ("instroot: ".$instroot);

	debug ("*** end: Satellite: get_instroot ***");
	return $instroot;
}

function send_element($table, $type, $data, $data_desc, $if_keep_id = 0)
{
	global $user;
	global $config;
	debug ("*** Satellite: send_element ***");

	debug("table: ".$table);
	debug("data desc:", 2);
	dump($data_desc);
	debug("data:", 2);
	dump($data);
	debug("url: ".$this -> url);

	$result = 0;
	$element = array();	

	foreach($data_desc as $k => $v)
	{
		$d = base64_encode($data[$k]);
		$element[$k] = new xmlrpcval($d, $v);
	}

	$t = new xmlrpcval($element, "struct");

	$client =new xmlrpc_client($this -> get_instroot()."/modules/base/xmlrpcserver.php", $this -> url);
	$message =new xmlrpcmsg('receive_element', array(
		new xmlrpcval(base64_encode($config['bbcpanel']['password']), "string"),
		new xmlrpcval(base64_encode($table), "string"),
		new xmlrpcval(base64_encode($type), "string"),
		new xmlrpcval(base64_encode($if_keep_id), "string"),
		$t
	));
	$response =$client->send($message);

	if (!$response ->faultCode(  ))
	{
		debug("Ответ XMLRPC сервера: ".htmlentities($response->serialize()));

		$v=$response->value();

		$result = $v -> scalarval();
		debug("result: ".$result);

	}
	else
	    debug("Проблема: Код: " . $response->faultCode(  ) . " Причина '" .$response->faultString(  )."'");
		

	debug ("*** end: Satellite: send_element ***");
	return $result;
}

function get_element($table, $id)
{
	global $user;
	global $config;
	debug("*** Satellite: get_element ***");

	$element = array();

	debug("table: ".$table);
	debug("id: ".$id);
	debug("url: ".$this -> url);

	$client =new xmlrpc_client($this -> get_instroot()."/modules/base/xmlrpcserver.php", $this -> url);
	$message =new xmlrpcmsg('get_element', array(
		new xmlrpcval(base64_encode($config['bbcpanel']['password']), "string"),
		new xmlrpcval(base64_encode($table), "string"),
		new xmlrpcval(base64_encode($id), "string")
	));
	$response =$client->send($message);

	if (!$response ->faultCode(  ))
	{
		debug("Ответ XMLRPC сервера: ".htmlentities($response->serialize()));
		$v=$response->value();
		while(list($name,$value) = $v->structeach())
		{
			$value = base64_decode($value->scalarval());
			$element[$name] = $value;
			if ("password" != $name)
				debug("name: ".$name.", value: ".$value);
			else
				debug("name: ".$name.", value: ******");
		}
	}
	else
	    debug("Проблема: Код: " . $response->faultCode(  ) . " Причина '" .$response->faultString(  )."'");

	debug("*** end: Satellite: get_element ***");
	return $element;
}

function get_config($config_table)
{
	global $user;
	global $config;
	debug("*** Satellite: get_config ***");

	$sat_config = array();

	$client =new xmlrpc_client($this -> get_instroot()."/modules/base/xmlrpcserver.php", $this -> get_url());
	$message =new xmlrpcmsg('get_config', array(
		new xmlrpcval($config['bbcpanel']['password'], "string"),
		new xmlrpcval($config_table, "string")
	));
	$response =$client->send($message);

	if (!$response ->faultCode(  ))
	{
		debug("Ответ XMLRPC сервера: ".htmlentities($response->serialize()));

		$v=$response->value();

		for($a = 0; $a < $v -> arraysize(); $a++)
		{
			$z = $v -> arraymem($a);

			$struct_id = $z -> structmem("id");
			$struct_name = $z -> structmem("name");
			$struct_value = $z -> structmem("value");
			$struct_descr = $z -> structmem("descr");

			$sat_config[$a]['id'] = $struct_id -> scalarval();
			$sat_config[$a]['name'] = $struct_name -> scalarval();
			$sat_config[$a]['value'] = $struct_value -> scalarval();
			$sat_config[$a]['descr'] = $struct_descr -> scalarval();
		}
	}
	else
	    debug("Проблема: Код: " . $response->faultCode(  ) . " Причина '" .$response->faultString(  )."'");
		
	debug("*** end: Satellite: get_config ***");
	return $sat_config;
}


function del_element($table, $id)
{
	global $user;
	global $config;
	debug("*** Satellite: del_element ***");

	debug("table: ".$table);
	debug("id: ".$id);

	$result = 0;

	$client =new xmlrpc_client($this -> get_instroot()."/modules/base/xmlrpcserver.php", $this -> url);
	$message =new xmlrpcmsg('del_element', array(
		new xmlrpcval(base64_encode($config['bbcpanel']['password']), "string"),
		new xmlrpcval(base64_encode($table), "string"),
		new xmlrpcval(base64_encode($id), "string")
	));
	$response =$client->send($message);

	if (!$response ->faultCode(  ))
	{
		debug("Ответ XMLRPC сервера: ".htmlentities($response->serialize()));
		$v=$response->value();
		$result = $v -> scalarval();
		debug("result: ".$result);
	}
	else
	    debug("Проблема: Код: " . $response->faultCode(  ) . " Причина '" .$response->faultString(  )."'");

	debug("*** end: Satellite: del_element ***");
	return $result;
}

function synchronize($table, $type)
{
	global $user;
	global $config;
	debug("*** Satellite: synchronize ***");
	debug("table: ".$table);
	debug("type: ".$type);
	$content = array(
		'type' => $type,
		'result' => '',
		'id' => $this -> id,
		'elements_qty' => ''
	);

	$elements_list = array();
	$elements = array();
	$result = 0;

	$client =new xmlrpc_client($this -> get_instroot()."/modules/base/xmlrpcserver.php", $this -> get_url());
	$message =new xmlrpcmsg('get_elements_list', array(
		new xmlrpcval(base64_encode($config['bbcpanel']['password']), "string"),
		new xmlrpcval(base64_encode($table), "string")
	));
	$response =$client->send($message);

	if (!$response ->faultCode(  ))
	{
		debug("Ответ XMLRPC сервера: ".htmlentities($response->serialize()));
		$result = 1;

		$v=$response->value();

		for($a = 0; $a < $v -> arraysize(); $a++)
		{
			$z = $v -> arraymem($a);

			$struct_id = $z -> structmem("id");

			$elements_list[] = $struct_id -> scalarval();
		}
	}
	else
	    debug("Проблема: Код: " . $response->faultCode(  ) . " Причина '" .$response->faultString(  )."'");

	if ($result)
	{
		debug("elements list:", 2);
		dump($elements_list);

		foreach($elements_list as $k => $v)
		{
			$element = $this -> get_element($table, $v);
			debug("element: ", 2);
			dump($element);
			$elements[] = $element;
		}

		$elements_qty = count($elements);
		debug("elements qty: ".$elements_qty);
		$content['elements_qty'] = $elements_qty;

		$new_table = $table."_".$this -> id;
		debug("new table: ".$new_table);

		$sql_query = "DELETE FROM `".mysql_real_escape_string($new_table)."`";
		exec_query($sql_query);

		foreach ($elements as $idx => $el)
		{
			$fields = "";
			$values = "";
			foreach ($el as $k => $v)
			{
				$fields .= "`".mysql_real_escape_string($k)."`,";
				$values .= "'".mysql_real_escape_string($v)."',";
			}
			$fields = rtrim($fields, ",");
			$values = rtrim($values, ",");

			$sql_query = "INSERT INTO `".mysql_real_escape_string($new_table)."` (".$fields.") VALUES (".$values.")";
			exec_query($sql_query);
		}
	}

	debug("*** end: Satellite: synchronize ***");
	return $content;
}

function do_action($action)
{
	global $user;
	global $config;
	debug("*** Satellite: do_action ***");

	debug("action: ".$action);

	$result = "";
	$params = explode("|", $action);
	debug("params:", 2);
	dump($params);
	$module = $params[0];
	debug("module: ".$module);
	$action = $params[1];
	debug("action: ".$action);
	if (isset($params[2]))
	{
		$par = $params[2];
		debug("parameter: ".$par);
	}

	$server_string = $this -> get_instroot()."/modules/".$module."/xmlrpcserver.php";

	$client =new xmlrpc_client($server_string, $this -> url);
	if (isset($par))
		$message =new xmlrpcmsg($action, array(
			new xmlrpcval(base64_encode($config['bbcpanel']['password']), "string"),
			new xmlrpcval(base64_encode($par), "string")
		));
	else
		$message =new xmlrpcmsg($action, array(new xmlrpcval(base64_encode($config['bbcpanel']['password']), "string")));

	$response =$client->send($message);
		debug("Ответ XMLRPC сервера: ".htmlentities($response->serialize()));

	if (!$response ->faultCode(  ))
	{
		debug("Ответ XMLRPC сервера: ".htmlentities($response->serialize()));
		$v=$response->value();
		$result = $v -> scalarval();
		debug("result: ".$result);
	}
	else
	{
		$result = "Проблема: Код: " . $response->faultCode(  ) . " Причина '" .$response->faultString(  )."'";
		debug($result);
	}

	debug("*** end: Satellite: do_action ***");
	return $result;
}


}

?>
