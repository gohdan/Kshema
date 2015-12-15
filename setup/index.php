<?php

function recurse_copy($src,$dst) {
	// gimmicklessgpt at gmail dot com , https://secure.php.net/manual/ru/function.copy.php
    $dir = opendir($src);
    @mkdir($dst);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                recurse_copy($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);
} 

echo <<<END
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Setup</title>
<link rel="stylesheet" href="/libs/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="/themes/default/css/admin.css" type="text/css" />
<script src="/libs/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
	  <div class="navbar-header">
		  <a class="navbar-brand">Setup</a>
      </div>
	</div>
</nav>
END;

if (isset($_POST['do_save']))
{
	if ("" != $_POST['new_theme'])
	{
		$theme_name = $_POST['new_theme'];
		$theme_dir = "../themes/".$theme_name;
		mkdir ($theme_dir);
		recurse_copy("../themes/default", $theme_dir);
	}
	else
	{
		$theme_name = $_POST['theme'];
		$theme_dir = "../themes/".$theme_name;
	}

	$config_file = "../config.php";
	$config_line = "<?php include_once (\"themes/".$theme_name."/config.php\"); ?>";

	file_put_contents($config_file, $config_line);


	$db_config_file = $theme_dir."/db_config.php";
	$db_params = "<?php

\$config['db']['old_engine'] = \"no\";
\$config['db']['charset'] = \"utf8\"; // cp1251 or utf8
\$config['db']['collation'] = \"utf8_unicode_ci\"; // cp1251_general_ci or utf8_unicode_ci

\$config['db']['db_user'] = \"".$_POST['db_user']."\";
\$config['db']['db_password'] = \"".$_POST['db_password']."\";
\$config['db']['db_name'] = \"".$_POST['db_name']."\";
\$config['db']['db_host'] = \"".$_POST['db_host']."\";

?>
";

	file_put_contents($db_config_file, $db_params);

	echo ("<br><p>Config files saved. Please check <b>/themes/".$theme_name."/config.php</b> manually. And don't forget to delete /setup/ directory.</p>");	
	echo ("<p><a href=\"/base/install/\">Go to setup admin account and basic DB tables</a> or <a href=\"/setup\">go through this setup again</a>.</p>");

}
else
{

echo <<<END
<h1>Setup</h1>

<form action="/setup/index.php" method="post">

<h2>Appearance theme</h2>


Theme: <select name="theme">
END;

$themes = scandir("../themes/");

foreach($themes as $k => $v)
	if ("." != $v && ".." != $v)
		echo ("<option value=\"".$v."\">".$v."</option>");
echo <<<END
</select><br>

or copy default theme to new: <input type="text" name="new_theme" placeholder="new theme name (allowed symbols: a-zA-Z0-9_-)" size="40">

<h2>MySQL connection parameters</h2>

<table>
<tr><td>Host: </td><td><input type="text" name="db_host" placeholder="Host name"></td></tr>
<tr><td>Database: </td><td><input type="text" name="db_name" placeholder="DB name"></td></tr>
<tr><td>User: </td><td><input type="text" name="db_user" placeholder="User name"></td></tr>
<tr><td>Password: </td><td><input type="text" name="db_password" placeholder="Password"></td></tr>
</table>

<br>

<input type="submit" name="do_save" value="Save">

</form>
END;
}

echo <<<END
</body>
</html>
END;

?>
