<table class="calculator">
<tr>
	<td class="bg">

		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<th width="57" height="225" rowspan="2" align="left" valign="top" scope="col"><img src="/themes/calc_adv/images/left.jpg" width="57" height="225" />
			</th>
			<th width="88%" height="114" scope="col">
<table class="calculator_form">
<tr>
<th>�����</th>
<th rowspan="2" height="42" class="bb" scope="col"><img src="/themes/calc_adv/images/bb.png" width="2" height="131" /></th>
<th>�����</th>
<th rowspan="2" height="42" class="bb" scope="col"><img src="/themes/calc_adv/images/bb.png" width="2" height="131" /></th>
<th>�����������</th>
<th rowspan="2" height="42" class="bb" scope="col"><img src="/themes/calc_adv/images/bb.png" width="2" height="131" /></th>
{{if:if_show_result_prime:
<th>
�������<br>� �����
</th>
<th rowspan="2" height="42" class="bb" scope="col"><img src="/themes/calc_adv/images/bb.png" width="2" height="131" /></th>
<th>
�������<br>�� � �����
</th>
<th rowspan="2" height="42" class="bb" scope="col"><img src="/themes/calc_adv/images/bb.png" width="2" height="131" /></th>
}}

{{if:if_show_result_time:#times#}}

<th>���������</th>
<th rowspan="2" height="42" class="bb" scope="col"><img src="/themes/calc_adv/images/bb.png" width="2" height="131" /></th>
<th>��������<br>�����������</th>
<th rowspan="2" height="42" class="bb" scope="col"><img src="/themes/calc_adv/images/bb.png" width="2" height="131" /></th>
<th>���������<br>� �����-���</th>
<th rowspan="2" height="42" class="bb" scope="col"><img src="/themes/calc_adv/images/bb.png" width="2" height="131" /></th>
{{if:if_noresident:
<th>�����-�<br>�������������</th>
<th rowspan="2" height="42" class="bb" scope="col"><img src="/themes/calc_adv/images/bb.png" width="2" height="131" /></th>
<th>��������� � ���������<br>�� �������������</th>
<th rowspan="2" height="42" class="bb" scope="col"><img src="/themes/calc_adv/images/bb.png" width="2" height="131" /></th>
}}
{{if:if_show_discount:<th>������</th>
<th rowspan="2" height="42" class="bb" scope="col"><img src="/themes/calc_adv/images/bb.png" width="2" height="131" /></th>
<th>�������� �����</th>
<th rowspan="2" height="42" class="bb" scope="col"><img src="/themes/calc_adv/images/bb.png" width="2" height="131" /></th>
}}
<th>�������</th>
<th rowspan="2" height="42" class="bb" scope="col"><img src="/themes/calc_adv/images/bb.png" width="2" height="131" /></th>
</tr>
<tr>
<td>#city_title#</td>
<td>#month_name#</td>
<td>#hron#</td>
{{if:if_show_result_prime:
<td>
#prime#
</td>
<td>
#noprime#
</td>
}}

{{if:if_show_result_time:#time_qtys#}}

<td>#sum#</td>
<td>#season_coef#</td>
<td>#sum_season#</td>
{{if:if_noresident:
<td>#noresident_coef#</td>
<td>#sum_noresident#</td>
}}
{{if:if_show_discount:<td>#discount#</td>
<td>#sum_final#</td>
}}
<td>
<form action="/index.php?module=calc_adv&action=calc" method="post">
<input type="hidden" name="result_id" value="#id#">
<input type="submit" name="do_del_result" value="X">
</form>
</td>
</tr>
</table>


</th>
			<th width="5%" rowspan="2" align="right" scope="col"><img src="/themes/calc_adv/images/right.jpg" width="45" height="225" /></th>
		</tr>
		</table>
	</td>
</tr>
</table>
