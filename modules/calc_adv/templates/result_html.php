<html>
<head>
<title>��������� ��� ������</title>
<style>
table
{
	border: 1px solid black;
	border-collapse: collapse;
}

th
{
	border: 1px solid black;
}

td
{
	border: 1px solid black;
}
</style>
</head>
<body>
<table>
<tr>
<th>�����</th>

<th>�����</th>

<th>�����������</th>

{{if:result_if_show_result_prime:
<th>
�������<br>� �����
</th>

<th>
�������<br>�� � �����
</th>

}}

{{if:result_if_show_result_time:#result_times_pure#}}

<th>���������</th>

<th>��������<br>�����������</th>

<th>���������<br>� �����-���</th>

{{if:result_if_noresident:
<th>�����-�<br>�������������</th>

<th>��������� � ���������<br>�� �������������</th>

}}
{{if:result_if_show_discount:<th>������, %</th>

<th>�������� �����</th>

}}
</tr>
<tr>
<td>#result_city_title#</td>
<td>#result_month_name#</td>
<td>#result_hron#</td>
{{if:result_if_show_result_prime:
<td>
#result_prime#
</td>
<td>
#result_noprime#
</td>
}}

{{if:result_if_show_result_time:#result_time_qtys#}}

<td>#result_sum#</td>
<td>#result_season_coef#</td>
<td>#result_sum_season#</td>
{{if:result_if_noresident:
<td>#result_noresident_coef#</td>
<td>#result_sum_noresident#</td>
}}
{{if:result_if_show_discount:<td>#result_discount#</td>
<td>#result_sum_final#</td>
}}
</tr>
</table>


</body>
