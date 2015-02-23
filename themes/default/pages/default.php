<?php

debug ("default page");

echo <<<END
<!DOCTYPE html>
<html>
<head>
<title>
END;
echo ($template['title']);
echo <<<END
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='stylesheet' href='/themes/default/css/main.css' type='text/css' />
END;

if ("" != $config['template']['css'])
	echo ("\n<link rel='stylesheet' href='".$config['template']['css']."' type='text/css' />\n");

include("includes/tinymce_init.php");

if (isset($_GET['action']) && "view_by_user" == $_GET['action'])
	include("includes/bills.php");

echo <<<END
</head>
<body>

END;

echo ($content);

echo <<<END
</body>
</html>
END;

?>
