<?php

debug ("admin page");

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
<link rel="stylesheet" href="/themes/default/css/admin.css" type="text/css" />
<script src="/libs/jquery.min.js"></script>
<script src="/libs/bootstrap/js/bootstrap.min.js"></script>
END;

foreach ($config['template']['css'] as $css_idx => $css_file)
	echo ("\n<link rel='stylesheet' href='".$css_file."' type='text/css' />\n");

include("includes/tinymce_init.php");

echo <<<END
</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
	  <div class="navbar-header">
	  <a class="navbar-brand">
END;

echo ($config['base']['site_name']);

echo <<<END
	  </a>
      </div>
	</div>
</nav>
END;

echo ($content);

echo <<<END
</body>
</html>
END;

?>
