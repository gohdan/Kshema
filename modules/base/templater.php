<?php

class Templater
{

function colonize($el_array, $cols_qty = 2)
{

	global $config;
	global $user;

	debug ("*** Templater: colonize ***");

	debug("elements array:", 2);
	dump($el_array);

	debug("cols qty: ".$cols_qty);

	$row_num = 1;
	$i = 1;

	foreach($el_array as $idx => $element)
	{
		debug("processing element ".$idx);
		debug("i: ".$i);

		if (1 == $row_num && 1 == $i)
			$el_array[$idx]['first_row'] = "yes";

		$el_array[$idx]['row_num'] = $row_num;

		if (1 == $i)
		{
			debug("begin row");
			$el_array[$idx]['row_begin'] = "yes";
			if (isset($el_array[$idx - 1]))
				$el_array[$idx]['row_previous'] = $row_num - 1;
		}

		if (0 == ($i % $cols_qty))
		{
			debug("end row");
			$el_array[$idx]['row_end'] = "yes";
			if (isset($el_array[$idx + 1]))
				$el_array[$idx]['row_next'] = $row_num + 1;
			$i = 1;
			$row_num++;
		}
		else
			$i++;
	}

	if (isset($idx))
		$el_array[$idx]['row_end'] = "yes";

	debug("new elements array:", 2);
	dump($el_array);

	debug ("*** end: Templater: colonize ***");

	return $el_array;
}

}

?>
