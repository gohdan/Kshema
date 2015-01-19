<?php

// Some common functions

function debug ($info, $level = 1)
{
	global $user;
    global $config;

	if (((1 == $user['id'] || $config['base']['debug_user'] == $user['id'] || "0" == $config['base']['debug_user'])) && $level <= $config['base']['debug_level'])
	{
		if (phpversion() >= 5.4)
			echo ("<span class=\"debug_info\">".htmlspecialchars($info, ENT_SUBSTITUTE, $config['base']['output_charset'])."</span><br>\n");
		else
			echo ("<span class=\"debug_info\">".htmlspecialchars($info)."</span><br>\n");
	}
    return 1;
}

function dump($var)
{
	global $user;
	global $config;

    if (((1 == $user['id']) || ($config['base']['debug_user'] == $user['id'])) && $config['base']['debug_level'] >= 2)
	{
		$info = (print_r($var, TRUE));

		if (phpversion() >= 5.4)
			$info = htmlspecialchars($info, ENT_SUBSTITUTE, $config['base']['output_charset']);
		else
			$info = htmlspecialchars($info);

		echo ("<span class=\"debug_info\"><pre>");
		echo($info);
		echo ("</pre></span>");
	}
	return 1;
}

function write_file_log($var, $level = 1)
{
	global $user;
	global $config;

	if($level <= $config['base']['debug_level'] || "yes" == $config['base']['logs_write'])
	{
		if (!file_exists($config['base']['logs_path']))
			mkdir($config['base']['logs_path']);

		$filename = $config['base']['logs_path'].date("Y_m_d").".txt";
		debug ("file name: ".$filename);

	   	if ($log = fopen($filename, 'a'))
		{
			if (is_writable($filename))
			{
				if (fwrite($log, date("H:i:s")." ".$var."\n\n"))
					debug("Success, wrote to file");
				else
					debug("Cannot write to file");
			}
			else
				debug("The file is not writable");
		    fclose($log);
		}
		else
			debug("Cannot open file");
	}
	return 1;
}

function base_get_month_name($month_number)
{
	switch ($month_number)
	{
		default: $month_name = "Нулябрь"; break;
		case "1": $month_name = "Январь"; break;
		case "2": $month_name = "Февраль"; break;
		case "3": $month_name = "Март"; break;
		case "4": $month_name = "Апрель"; break;
		case "5": $month_name = "Май"; break;
		case "6": $month_name = "Июнь"; break;
		case "7": $month_name = "Июль"; break;
		case "8": $month_name = "Август"; break;
		case "9": $month_name = "Сентябрь"; break;
		case "10": $month_name = "Октябрь"; break;
		case "11": $month_name = "Ноябрь"; break;
		case "12": $month_name = "Декабрь"; break;
	}
	return $month_name;
}

function base_get_month_name_genetive($month_number)
{
	switch ($month_number)
	{
		default: $month_name = "нулября"; break;
		case "1": $month_name = "января"; break;
		case "2": $month_name = "февраля"; break;
		case "3": $month_name = "марта"; break;
		case "4": $month_name = "апреля"; break;
		case "5": $month_name = "мая"; break;
		case "6": $month_name = "июня"; break;
		case "7": $month_name = "июля"; break;
		case "8": $month_name = "августа"; break;
		case "9": $month_name = "сентября"; break;
		case "10": $month_name = "октября"; break;
		case "11": $month_name = "ноября"; break;
		case "12": $month_name = "декабря"; break;
	}
	return $month_name;
}

function base_get_month_num($month_name, $digits)
{
	switch ($month_name)
	{
		default: $month_num = 1; break;
		case "Jan": $month_num = "01"; break;
		case "Feb": $month_num = "02"; break;
		case "Mar": $month_num = "03"; break;
		case "Apr": $month_num = "04"; break;
		case "May": $month_num = "05"; break;
		case "Jun": $month_num = "06"; break;
		case "Jul": $month_num = "07"; break;
		case "Aug": $month_num = "08"; break;
		case "Sep": $month_num = "09"; break;
		case "Oct": $month_num = "10"; break;
		case "Nov": $month_num = "11"; break;
		case "Dec": $month_num = "12"; break;

	}
	return $month_num;
}

function base_get_month_days($month_number, $year = 0)
{
	switch ($month_number)
	{
		default: $days = 0; break;
		case "1": $days = 31; break;
		case "2":
			if ((0 != $year) & (!($year % 4) && (($year % 100) || !($year % 400))))
				$days = 29;
			else
				$days = 28;
		break;
		case "3": $days = 31; break;
		case "4": $days = 30; break;
		case "5": $days = 31; break;
		case "6": $days = 30; break;
		case "7": $days = 31; break;
		case "8": $days = 31; break;
		case "9": $days = 30; break;
		case "10": $days = 31; break;
		case "11": $days = 30; break;
		case "12": $days = 31; break;
	}
	return $days;
}

function base_get_weekday_name($number)
{
	switch ($number)
	{
		default: break;
		case "1":
			$name = "Понедельник";
		break;
		case "2":
			$name = "Вторник";
		break;
		case "3":
			$name = "Среда";
		break;
		case "4":
			$name = "Четверг";
		break;
		case "5":
			$name = "Пятница";
		break;
		case "6":
			$name = "Суббота";
		break;
		case "7":
			$name = "Воскресенье";
		break;
	}
	return $name;
}

function transliterate($string, $lang_from, $lang_to, $if_safe = 1)
{
	debug("string: ".$string);
	debug("lang_from: ".$lang_from);
	debug("lang_to: ".$lang_to);
	debug("if safe: ".$if_safe);

	$new_string = "";

	if ("ru" == $lang_from && "en" == $lang_to)
	{
			$new_string = strtr($string, array(
			'а'=>'a',	'б'=>'b',	'в'=>'v',	'г'=>'g',	'д'=>'d',
			'е'=>'e',	'ж'=>'j',	'з'=>'z',	'и'=>'i',	'й'=>'y',
			'к'=>'k',	'л'=>'l',	'м'=>'m',	'н'=>'n',	'о'=>'o',
			'п'=>'p',	'р'=>'r',	'с'=>'s',	'т'=>'t',	'у'=>'u',
			'ф'=>'f',	'ы'=>'y',	'э'=>'e',

			'А'=>'A',	'Б'=>'B',	'В'=>'V',	'Г'=>'G',	'Д'=>'D',
			'Е'=>'E',	'Ж'=>'J',	'З'=>'Z',	'И'=>'I',	'Й'=>'Y',
			'К'=>'K',	'Л'=>'L',	'М'=>'M',	'Н'=>'N',	'О'=>'O',
			'П'=>'P',	'Р'=>'R',	'С'=>'S',	'Т'=>'T',	'У'=>'U',
			'Ф'=>'F',	'Ы'=>'Y',	'Э'=>'E',

			'ё'=>"yo",	'х'=>"h",  'ц'=>"ts",  'ч'=>"ch", 'ш'=>"sh",  
			'щ'=>"sch",	'ъ'=>'',   'ь'=>'',    'ю'=>"yu", 'я'=>"ya",
			'Ё'=>"Yo",    'Х'=>"H",  'Ц'=>"Ts",  'Ч'=>"Ch", 'Ш'=>"Sh",
			'Щ'=>"Sch",   'Ъ'=>'',   'Ь'=>'',    'Ю'=>"Yu", 'Я'=>"Ya"
			));
	}

	if ($if_safe)
			$new_string = strtr($new_string, array(
				' '=>'-', '?'=>'', ','=>'', '.'=>'', ':'=>'-', '«'=>'', '»'=>'', ';'=>'-', '!'=>'-', '&'=>'-'
			));

	return $new_string;
}

// Performs URL processing to fill $_GET

function base_process_request()
{
	global $user;
	global $config;
	debug("*** base_process_request ***");

	if (isset($_GET['query']))
		debug("get query: ".$_GET['query']);

	debug("GET:", 2);
	dump($_GET);

	if (isset($_GET['query']) && ("admin" == $_GET['query'] || "admin/" == $_GET['query']))
	{
		debug("redirecting to admin");
		$_GET['module'] = "auth";
		$_GET['action'] = "show_login_form";
	}
	else if (isset($_GET['query']) && !strstr($_GET['query'], "&"))
	{
		debug("using human-friendly url");
		$_GET['query'] = rtrim($_GET['query'], "/");
		$params = explode("/", $_GET['query']);
		dump($params);

		foreach ($params as $k => $v)
		{
			debug("processing param ".$v);

			if (in_array($v, $config['base']['lang']['list']))
			{
				debug("looks like a language");
				$config['base']['lang']['current'] = $v;
				$_GET['language'] = $v;
				debug("set default language to ".$config['base']['lang']['current']);
			}
			else if (preg_match('/page(\d+).html/s', $v, $matches))
			{
				debug("looks like a page");
				// preg_match('/(\d+)/s', $v, $matches); 
				debug("matches", 2);
				dump($matches);
				debug("page: ".$matches[1]);
				$_GET['page'] = $matches[1];
			}
			else if (preg_match('/([a-zA-Z0-9-_]+).html/s', $v, $matches))
			{
				debug("looks like an element to view");
				// preg_match('/(\d+)/s', $v, $matches); 
				debug("matches", 2);
				dump($matches);
				debug("element: ".$matches[1]);
				$_GET['element'] = $matches[1];
				$_GET['action'] = "view";
			}
			else if (preg_match('/satellite_(\d+)/s', $v, $matches))
			{
				debug("looks like a satellite");
				debug("matches", 2);
				dump($matches);
				debug("satellite: ".$matches[1]);
				$_GET['satellite'] = $matches[1];
			}
			else if (preg_match('/:/s', $v, $matches))
			{
				debug("looks like a GET parameter");
				debug("matches", 2);
				dump($matches);
				$param = explode(":", $v);
				debug ($param[0]." is ".$param[1]);
				$_GET[$param[0]] = $param[1];
			}
			else if ("" != $v)
			{
				if (isset($_GET['language']))
					$k--;
				switch($k)
				{
					default:
					break;

					case "0":
						debug("looks like a module");
						if (module_exists($v))
						{
							debug("module exists");
							$_GET['module'] = $v;
						}
						else
						{
							debug("module doesn't exist, using default module");
							$_GET['module'] = $config['modules']['default_module'];
							include_once ($config['modules']['location']."/".$_GET['module']."/index.php");
							$fn = $_GET['module']."_get_actions_list";
							if (in_array($v, $fn()))
							{
								debug("action exists, treat parameter like an action");
								$_GET['action'] = $v;
							}
							else
							{
								debug("action doesn't exist, using default action, treat parameter as an element");
								$_GET['action'] = $config[$_GET['module']]['default_action'];
								$_GET['element'] = $v;
							}
						}
					break;
	
					case "1":
						debug("treat like an action");
						$_GET['action'] = $v;
					break;

					case "2":
						debug("treat like an element");
						$_GET['element'] = $v;
					break;
				}
			}
		}
	}
	debug("new GET:", 2);
	dump($_GET);

	debug("*** end: base_process_request ***");
	return 1;
}

if(!function_exists('scandir')) {  
    function scandir($dir, $sortorder = 0) {  
        if(is_dir($dir) && $dirlist = @opendir($dir)) {  
            while(($file = readdir($dirlist)) !== false) {  
                $files[] = $file;  
            }  
            closedir($dirlist);  
            ($sortorder == 0) ? asort($files) : rsort($files); // arsort was replaced with rsort  
            return $files;  
        } else return false;  
    }  
}

if(!function_exists('mime_content_type'))
{
	function mime_content_type($file)
	{
		$ct['htm'] = 'text/html';
		$ct['html'] = 'text/html';
		$ct['txt'] = 'text/plain';
		$ct['asc'] = 'text/plain';
		$ct['bmp'] = 'image/bmp';
		$ct['gif'] = 'image/gif';
		$ct['jpeg'] = 'image/jpeg';
		$ct['jpg'] = 'image/jpeg';
		$ct['jpe'] = 'image/jpeg';
		$ct['png'] = 'image/png';
		$ct['ico'] = 'image/vnd.microsoft.icon';
		$ct['mpeg'] = 'video/mpeg';
		$ct['mpg'] = 'video/mpeg';
		$ct['mpe'] = 'video/mpeg';
		$ct['qt'] = 'video/quicktime';
		$ct['mov'] = 'video/quicktime';
		$ct['avi'] = 'video/x-msvideo';
		$ct['wmv'] = 'video/x-ms-wmv';
		$ct['mp2'] = 'audio/mpeg';
		$ct['mp3'] = 'audio/mpeg';
		$ct['rm'] = 'audio/x-pn-realaudio';
		$ct['ram'] = 'audio/x-pn-realaudio';
		$ct['rpm'] = 'audio/x-pn-realaudio-plugin';
		$ct['ra'] = 'audio/x-realaudio';
		$ct['wav'] = 'audio/x-wav';
		$ct['css'] = 'text/css';
		$ct['zip'] = 'application/zip';
		$ct['pdf'] = 'application/pdf';
		$ct['doc'] = 'application/msword';
		$ct['bin'] = 'application/octet-stream';
		$ct['exe'] = 'application/octet-stream';
		$ct['class']= 'application/octet-stream';
		$ct['dll'] = 'application/octet-stream';
		$ct['xls'] = 'application/vnd.ms-excel';
		$ct['ppt'] = 'application/vnd.ms-powerpoint';
		$ct['wbxml']= 'application/vnd.wap.wbxml';
		$ct['wmlc'] = 'application/vnd.wap.wmlc';
		$ct['wmlsc']= 'application/vnd.wap.wmlscriptc';
		$ct['dvi'] = 'application/x-dvi';
		$ct['spl'] = 'application/x-futuresplash';
		$ct['gtar'] = 'application/x-gtar';
		$ct['gzip'] = 'application/x-gzip';
		$ct['js'] = 'application/x-javascript';
		$ct['swf'] = 'application/x-shockwave-flash';
		$ct['tar'] = 'application/x-tar';
		$ct['xhtml']= 'application/xhtml+xml';
		$ct['au'] = 'audio/basic';
		$ct['snd'] = 'audio/basic';
		$ct['midi'] = 'audio/midi';
		$ct['mid'] = 'audio/midi';
		$ct['m3u'] = 'audio/x-mpegurl';
		$ct['tiff'] = 'image/tiff';
		$ct['tif'] = 'image/tiff';
		$ct['rtf'] = 'text/rtf';
		$ct['wml'] = 'text/vnd.wap.wml';
		$ct['wmls'] = 'text/vnd.wap.wmlscript';
		$ct['xsl'] = 'text/xml';
		$ct['xml'] = 'text/xml';

		$extension = array_pop(explode('.',$file)); 

		if (!$type = $ct[strtolower($extension)])
			$type = 'text/html';

		return $type;
	}
}

function format_bytes($bytes)
{
   if ($bytes < 1024) return $bytes.' б.';
   elseif ($bytes < 1048576) return round($bytes / 1024, 0).' КБ';
   elseif ($bytes < 1073741824) return round($bytes / 1048576, 2).' МБ';
   elseif ($bytes < 1099511627776) return round($bytes / 1073741824, 2).' ГБ';
   else return round($bytes / 1099511627776, 2).' TB';
}

function format_date($date, $format)
{
	switch ($format)
	{
		default: $date_new = $date; break;

		case "ru":
			$dt = explode("-", $date);
			$date_new = $dt[2].".".$dt[1].".".$dt[0];
		break;

		case "mysql":
			$dt = explode(".", $date);
			$date_new = $dt[2]."-".$dt[1]."-".$dt[0];
		break;

	}

	return $date_new;
}

function date_get_days_qty($date1, $date2)
{
	debug("*** date_get_days_qty ***");
	$ts_in_day = 86400;

	debug("date1: ".$date1);
	debug("date2: ".$date2);
	
	$dt1 = explode("-", $date1);
	$ts_date1 = mktime(0, 0, 0, $dt1[1], $dt1[2], $dt1[0]);
	debug("ts_date1: ".$ts_date1);

	$dt2 = explode("-", $date2);
	$ts_date2 = mktime(0, 0, 0, $dt2[1], $dt2[2], $dt2[0]);
	debug("ts_date2: ".$ts_date2);

	if ($ts_date2 >= $ts_date1)
		$ts = $ts_date2 - $ts_date1;
	else
		$ts = $ts_date1 - $ts_date2;

	debug("ts: ".$ts);

	$days_qty = $ts / $ts_in_day;

	debug("days_qty: ".$days_qty);

	debug("*** date_get_days_qty ***");
	return($days_qty);

}

function date_get_days_list($date1, $date2)
{
	debug("*** date_get_days_list ***");

	$days_list = array();
	$ts_in_day = 86400;

	debug("date1: ".$date1);
	debug("date2: ".$date2);
	
	$dt1 = explode("-", $date1);
	$ts_date1 = mktime(0, 0, 0, $dt1[1], $dt1[2], $dt1[0]);
	debug("ts_date1: ".$ts_date1);

	$dt2 = explode("-", $date2);
	$ts_date2 = mktime(0, 0, 0, $dt2[1], $dt2[2], $dt2[0]);
	debug("ts_date2: ".$ts_date2);

	if ($ts_date1 > $ts_date2)
	{
		$ts_temp = $ts_date2;
		$ts_date2 = $ts_date1;
		$ts_date1 = $ts_temp;
	}

	while ($ts_date1 <= $ts_date2)
	{
		$days_list[] = date("Y-m-d", $ts_date1);
		$ts_date1 = $ts_date1 + $ts_in_day;
	}




	debug("*** date_get_days_list ***");
	return($days_list);

}

function date_get_boa($date, $mode)
{
global $user;
global $config;
debug ("*** date_get_boa ***");

$dt = explode("-", $date);
$ts_date = mktime(0, 0, 0, $dt[1], $dt[2], $dt[0]);

$weekday = date("w", $ts_date);
if ("0" == $weekday)
	$weekday = 7;
$ts_in_day = 86400;

switch ($mode)
{
	default: break;

	case "before":
		$ts = $ts_date - ($ts_in_day * ($weekday + 6));
	break;

	case "after":
		$ts = $ts_date + ($ts_in_day * (7 - $weekday + 1));
	break;

	case "monday":
		$ts = $ts_date - ($ts_in_day * ($weekday - 1));
	break;

	case "sunday":
		$ts = $ts_date + ($ts_in_day * (7 - $weekday));
	break;

	case "monday_before":
		$ts = $ts_date - ($ts_in_day * ($weekday + 6));
	break;

	case "sunday_before":
		$ts = $ts_date - ($ts_in_day * $weekday);
	break;

}

$date_new = date("Y-m-d", $ts);


debug ("*** date_get_boa ***");
return $date_new;
}

function phone_number_validate($num)
{
	global $user;
	global $config;

	debug("*** phone_number_validate ***");

	$result = 1;

	debug("*** end: phone_number_validate ***");
	return $result;
}

function phone_number_transform($num)
{
	global $user;
	global $config;

	debug("*** phone_number_transform ***");

	debug("num: ".$num);

	$new_num = "";
	$bad_symbols = array(' ', '-', '(', ')');
	$numbers = array ('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
	
		if ("" == $num)
		{
			debug("number is empty");
			$new_num = "+";
		}
		else
		{
			debug("number is not empty");
			$len = strlen($num);
			debug("length: ".$len);

			for ($i = 0; $i < $len; $i++)
			{
				debug("i: ".$i);
				$symbol = substr($num, $i, 1);
				debug ("symbol: ".$symbol);
				if (in_array($symbol, $numbers))
					$new_num .= $symbol;
			}
			debug("new num: ".$new_num);

			if ("8" == substr($new_num, 0, 1) && "8800" != substr($new_num, 0, 4))
			{
				$new_num = ltrim($new_num, 8);
				$new_num = "7" . $new_num;
			}
			if ("8800" != substr($new_num, 0, 4))
				$new_num = "+" . $new_num;
		}


	debug("*** end: phone_number_transform ***");
	return $new_num;
}

function mb_strcasecmp($str1, $str2, $encoding = null)
{
    if (null === $encoding)
		$encoding = mb_internal_encoding();

	$str1_up = mb_strtoupper($str1, $encoding);
	$str2_up = mb_strtoupper($str2, $encoding);


	$val = strcmp($str1_up, $str2_up);
    
	return $val;
}

?>
