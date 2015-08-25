<?php

if ((isset($_GET['action'])) && ((FALSE !== strpos($_GET['action'], "add")) || (FALSE !== strpos($_GET['action'], "edit"))))
echo <<<END

<script language="javascript" type="text/javascript" src="/libs/tinymce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="/themes/default/js/tinymce_init.js"></script>

END;

?>
