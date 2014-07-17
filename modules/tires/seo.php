<?php

// SEO functions



function tires_generate_seo_data($params)
{
	global $user;
	global $config;
	//$config['base']['debug_level'] = "3";	
	debug("*** tires_generate_seo_data ***");

	debug("params:");
	dump($params);

	foreach($params as $k => $v)
		if (in_array($k, $config['tires']['own_tables']))
			$params[$k] = tires_get_own_table_title($k, $v);

	debug("changed params:");
	dump($params);

	$h1_parts = array(
		'source' => '',
		'season' => '',
		'shiny' => '�������� ���',
		'brand' => '',
		'radius' => '',
		'width' => '',
		'type' => ' ��� �������� �����������', //"��������" == $params['type']
		'model' => " ".$params['model']." ",
		'tail' => ' � �������'
	);

	$title_parts = array(
		'source' => '',
		'season' => '',
		'shiny' => '����',
		'brand' => '',
		'radius' => '',
		'width' => '',
		'type' => ' ��� �������� �����������', //"��������" == $params['type']
		'model' => " ".$params['model']." ",
		'tail' => ', ������ � ������� � ������ � �������� ���������, ����'
	);


	if ($config['tires']['unk'] != $params['brand'])
	{
		$h1_parts['brand'] = " ".$params['brand'];
		$title_parts['brand'] = " ".$params['brand'];
	}

	if ($config['tires']['unk'] != $params['radius'])
	{
		$h1_parts['radius'] = " R".$params['radius'];
		$title_parts['radius'] = " R".$params['radius']." (�������)";
	}

	if ($config['tires']['unk'] != $params['width'])
	{
		$h1_parts['width'] = " ������� ".$params['width'];
		$title_parts['width'] = " ������� ".$params['width'];
	}

	if ($config['tires']['unk'] != $params['source'])
	{
		$h1_parts['shiny'] = "����";
		$title_parts['shiny'] = "����";

		if ("���������" == $params['source'])
		{
			$h1_parts['source'] = "��������� ";
			$title_parts['source'] = "��������� ";
		}
		else if ("�������������" == $params['source'])
		{
			$h1_parts['source'] = "������������� ";
			$title_parts['source'] = "������������� ";
		}
	}

	if ($config['tires']['unk'] != $params['season'])
	{
		$h1_parts['shiny'] = "����";
		$title_parts['shiny'] = "���� (������)";

		if ("������" == $params['season'])
		{	
			if ($config['tires']['unk'] == $params['source'])
			{
				$h1_parts['season'] = "������ ";
				$title_parts['season'] = "������ ";
			}
			else
			{
				$h1_parts['season'] = "������ ";
				$title_parts['season'] = "������ ";
			}
		}
		else if ("������" == $params['season'])
		{
			if ($config['tires']['unk'] == $params['source'])
			{
				$h1_parts['season'] = "������ ";
				$title_parts['season'] = "������ ";
			}
			else
			{
				$h1_parts['season'] = "������ ";
				$title_parts['season'] = "������ ";
			}
		}
		else if ("�����������" == $params['season'])
		{
			if ($config['tires']['unk'] == $params['source'])
			{
				$h1_parts['season'] = "����������� ";
				$title_parts['season'] = "����������� ";
			}
			else
			{
				$h1_parts['season'] = "����������� ";
				$title_parts['season'] = "����������� ";
			}
		}
	}

	if ($config['tires']['unk'] != $params['spikes'])
	{
		if ("����" == $params['spikes'])
		{
		
			if ("" != $h1_parts['source'] || "" != $h1_parts['season'])
			{
				$h1_parts['source'] = str_replace("��", "��", $h1_parts['source']);
				$h1_parts['season'] = str_replace("��", "��", $h1_parts['season']);
				$h1_parts['shiny'] = "���������� ������ ";
			}
			else
				$h1_parts['shiny'] = "���������� ������ ";

			if ("" != $title_parts['source'] || "" != $title_parts['season'])
			{
				$title_parts['source'] = str_replace("��", "��", $title_parts['source']);
				$title_parts['season'] = str_replace("��", "��", $title_parts['season']);
				$title_parts['shiny'] = "���������� ������ ";
			}
			else
				$title_parts['shiny'] = "���������� ������ ";
		}
		else if ("������" == $params['season'])
		{
			$h1_parts['shiny'] = "���� ������� ";
			$title_parts['shiny'] = "���� ������� ";
		}

	}


	if (tires_if_all_params_set($params)) // viewing tire
	{
		$h1_parts['shiny'] = '���� ';
		$title_parts['shiny'] = '���� ';

		$seo_data = array(
			'h1' => 
				$h1_parts['shiny'].
				$h1_parts['brand'].
				$h1_parts['model'].
				$h1_parts['tail'],
			'title' => 
				$h1_parts['shiny'].
				$h1_parts['brand'].
				$h1_parts['model'].
				$h1_parts['tail'],
		);
	}
	else
		$seo_data = array(
			'h1' =>
				$h1_parts['source'].
				$h1_parts['season'].
				$h1_parts['shiny'].
				$h1_parts['type'].
				$h1_parts['brand'].
				$h1_parts['radius'].
				$h1_parts['width'].
				$h1_parts['tail'],
			'title' =>
				$title_parts['source'].
				$title_parts['season'].
				$title_parts['shiny'].
				$title_parts['type'].
				$title_parts['brand'].
				$title_parts['radius'].
				$title_parts['width'].
				$title_parts['tail']
		);

	debug("seo_data:");
	dump($seo_data);

	debug("*** end: tires_generate_seo_data ***");
	//$config['base']['debug_level'] = "0";

	return $seo_data;
}

?>
