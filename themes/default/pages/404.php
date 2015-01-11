<?php

debug ("404 page");

echo <<<END
<!DOCTYPE html>
<html>
<head>
<title>404</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='stylesheet' href='/themes/default/css/main.css' type='text/css' />
</head>
<body>

END;

echo ("Такой страницы не существует.");

echo ($content);

echo <<<END
</body>
</html>
END;

?>
