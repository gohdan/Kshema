<?php

debug ("front page");

echo ("<!DOCTYPE html>\n");
echo ("<html lang=\"".$config['base']['lang']['current']."\">\n");

echo <<<END
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

END;
echo ("<meta name=\"description\" content=\"".$config['themes']['meta_description']."\">\n");
echo ("<meta name=\"keywords\" content=\"".$config['themes']['meta_keywords']."\">\n");

echo ("<title>".$config['base']['site_name']."</title>");
echo ("<link rel=\"stylesheet\" href=\"".$config['base']['inst_root']."/themes/".$config['themes']['current']."/css/main.css\" type=\"text/css\" />");

echo <<<END
</head>
<body>
END;

echo ("<h1>".$config['base']['site_name']."</h1>");


echo ($content);

echo <<<END
</body>
</html>
END;

?>
