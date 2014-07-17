<?php

echo ("<script type=\"text/javascript\" src=\"/libs/mootools.js\"></script>\n");

$theme_current = $config['themes']['current'];
$site_url = $config['base']['site_url'];
echo <<<END
<script>
function results_unfold(id)
{
	var container = 'results_' + id;
	image_id = 'fold_img_' + id;

	var myFx = new Fx.Tween(container);
	image = $(image_id);
	if ('$site_url/themes/$theme_current/images/unfold.gif' == image.src)
	{
		myFx.set('display', 'block');
		image.src = '/themes/$theme_current/images/fold.gif';
	}
	else
	{
		myFx.set('display', 'none');
		image.src = '/themes/$theme_current/images/unfold.gif';
	}
}
</script>
END;

