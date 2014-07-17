<?php

if ((isset($_GET['action'])) && ((FALSE !== strpos($_GET['action'], "add")) || (FALSE !== strpos($_GET['action'], "edit"))))
echo <<<END
<script language="javascript" type="text/javascript" src="/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="/js/tinymce/init.js"></script>
END;

?>
