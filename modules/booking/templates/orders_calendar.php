<h1>��������� �������</h1>

<p>
<a href="/booking/admin/">��������� � ����������������� �������</a><br>
</p>

<p>#result#</p>

<p>#content#</p>

<form action="/booking/orders_calendar/" method="post">

<p>
�����: <select name="hotel">
<option value="1">Villawatuna</option>
</select>

<input type="radio" name="show_mode" value="1"{{if:show_mode_1_checked: checked}}> �����������
<input type="radio" name="show_mode" value="2"{{if:show_mode_2_checked: checked}}> �������������

</p>

������ �������:
<select name="month_begin">
<option value="1"{{if:month_begin_1_selected: selected}}>������</option>
<option value="2"{{if:month_begin_2_selected: selected}}>�������</option>
<option value="3"{{if:month_begin_3_selected: selected}}>����</option>
<option value="4"{{if:month_begin_4_selected: selected}}>������</option>
<option value="5"{{if:month_begin_5_selected: selected}}>���</option>
<option value="6"{{if:month_begin_6_selected: selected}}>����</option>
<option value="7"{{if:month_begin_7_selected: selected}}>����</option>
<option value="8"{{if:month_begin_8_selected: selected}}>������</option>
<option value="9"{{if:month_begin_9_selected: selected}}>��������</option>
<option value="10"{{if:month_begin_10_selected: selected}}>�������</option>
<option value="11"{{if:month_begin_11_selected: selected}}>������</option>
<option value="12"{{if:month_begin_12_selected: selected}}>�������</option>
</select>

<select name="year_begin">
<option value="#year_0#"{{if:year_begin_0_selected: selected}}>#year_0#</option>
<option value="#year_1#"{{if:year_begin_1_selected: selected}}>#year_1#</option>
</select>

����� �������:
<select name="month_end">
<option value="1"{{if:month_end_1_selected: selected}}>������</option>
<option value="2"{{if:month_end_2_selected: selected}}>�������</option>
<option value="3"{{if:month_end_3_selected: selected}}>����</option>
<option value="4"{{if:month_end_4_selected: selected}}>������</option>
<option value="5"{{if:month_end_5_selected: selected}}>���</option>
<option value="6"{{if:month_end_6_selected: selected}}>����</option>
<option value="7"{{if:month_end_7_selected: selected}}>����</option>
<option value="8"{{if:month_end_8_selected: selected}}>������</option>
<option value="9"{{if:month_end_9_selected: selected}}>��������</option>
<option value="10"{{if:month_end_10_selected: selected}}>�������</option>
<option value="11"{{if:month_end_11_selected: selected}}>������</option>
<option value="12"{{if:month_end_12_selected: selected}}>�������</option>
</select>

<select name="year_end">
<option value="#year_0#"{{if:year_end_0_selected: selected}}>#year_0#</option>
<option value="#year_1#"{{if:year_end_1_selected: selected}}>#year_1#</option>
</select>

������: <select name="rooms_filter">
<option value="all"{{if:all_selected: selected}}>���</option>
<option value="busy"{{if:busy_selected: selected}}>�������</option>
<option value="paid"{{if:paid_selected: selected}}>����������</option>
<option value="unpaid"{{if:unpaid_selected: selected}}>������������</option>
<option value="prepaid"{{if:prepaid_selected: selected}}>������� ����������</option>
</select>

<input type="submit" name="do_update" value="��������">


</form>


#calendar_monthes#


