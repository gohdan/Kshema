<?php

debug ("default page");

echo ("<!DOCTYPE html>\n");
echo ("<html lang=\"".$config['base']['lang']['current']."\">\n");

echo <<<END
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

END;

echo ("<title>".$template['title']."</title>\n");

echo <<<END
<link rel="stylesheet" href="/libs/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="/themes/default/css/main.css" type="text/css" />
<script src="/libs/jquery.min.js"></script>
<script src="/libs/bootstrap/js/bootstrap.min.js"></script>
END;

foreach ($config['template']['css'] as $css_idx => $css_file)
	echo ("\n<link rel='stylesheet' href='".$css_file."' type='text/css' />\n");

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
