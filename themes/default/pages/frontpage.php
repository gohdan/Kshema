<?php

debug ("front page");

echo <<<END
<html>
<head>
    <title>Kshema</title>
    <link rel='stylesheet' href='/themes/default/css/main.css' type='text/css' />
</head>
<body>

<h1>Главная страница</h1>
END;

echo ($content);

include_once ($config['modules']['location']."news/index.php");
echo (gen_content("news", "hook", news_hook()));

echo <<<END
</body>
</html>
END;

?>