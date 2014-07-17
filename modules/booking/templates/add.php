#content#

{{if:show_result_ru:<p>������� ��� �� ������������� ����� ������� ������������. � ��������� ����� ���� ��������� �������� � ����.</p>}}
{{if:show_result_en:<p>Thank you for using our reservation system. In the near future, our managers will contact you.</p>}}
{{if:show_result_de:<p>Vielen Dank f&uuml;r die Benutzung unserer Reservierungs-System. In naher Zukunft wird unser Manager mit Ihnen Kontakt aufnehmen.</p>}}
{{if:show_result_worker:<p>����� ��������</p>}}

{{if:show_admin_link:
<p>
<a href="/booking/admin/">���� ����������������� �����</a><br>
</p>
}}
{{if:show_form:

<form name="Q" action="/booking/add/page_template:orders_calendar" method="post">
<table summary="booking add table" class="booking_add_table">
<tr><td>�������</td><td><select name="room"><option value="0">-</option>#order_edit_rooms_select#</select></td></tr>
<tr><td>���� ���������</td><td><input type="text" name="date_from" id="date_from" size="10"></td></tr>
<tr><td>����� ���������</td><td><input type="text" name="time_from" size="5"></td></tr>
<tr><td>���� ���������</td><td><input type="text" name="date_to" id="date_to" size="10"></td></tr>
<tr><td>����� ���������</td><td><input type="text" name="time_to" size="5"></td></tr>
<tr><td>����� ����</td><td><input type="text" name="days" id="days_qty" size="2"> <a href="#" onClick="javascript:days_count()">�����������</a></td></tr>
<tr><td>������</td><td><input type="text" name="price" id="price" size="4"></td></tr>
<tr><td>���</td><td><input type="text" name="name"></td></tr>
<tr><td>�������</td><td><input type="text" name="surname"></td></tr>
<tr><td>�������</td><td><input type="text" name="phone"></td></tr>
<tr><td>E-mail</td><td><input type="text" name="email"></td></tr>
<tr><td>������</td><td><input type="text" name="country"></td></tr>
<tr><td>�������</td><td><select name="variant">
<option value="1"{{if:variant_1_selected: selected}}>Standard</option>
<option value="2"{{if:variant_2_selected: selected}}>Deluxe</option>
<option value="3"{{if:variant_3_selected: selected}}>Apartments</option>
</select></td></tr>
<tr><td>���������� ��������</td><td><input type="text" name="adults_qty" size="2"></td></tr>
<tr><td>�����������</td><td><input type="text" name="comment"></td></tr>
<tr><td>���� �� 12-�� ���</td><td><input type="checkbox" name="if_children" value="1"</td></tr>
<tr><td>�������������� �������</td><td><input type="checkbox" name="if_extra_bed" value="1"></td></tr>
<tr><td>�������� �� ���������</td><td><input type="checkbox" name="if_transfer" value="1"</td></tr>
<tr><td>���������� ���������</td><td><input type="text" name="breakfast_qty" size="2"></td></tr>
<tr><td>���������� ������</td><td><input type="text" name="passport"></td></tr>
<tr><td>��� ������</td><td><input type="text" name="payment_type"></td></tr>
<tr><td>��������� �����</td><td><input type="text" name="cost" id="cost" size="5"> <a href="#" onClick="javascript:cost_count()">�����������</a></td></tr>
<tr><td>����������</td><td><input type="text" name="prepayment"></td></tr>
<tr><td>�������</td><td><input type="text" name="leftover" size="5"></td></tr>
<tr><td>������ ������</td><td><input type="text" name="payment_status"></td></tr>
<tr><td>��������</td><td><input type="text" name="manager"></td></tr>
<tr><td>���������</td><td><input type="text" name="dealer"></td></tr>
<td></td><td><input type="submit" name="do_add" value="�������������"></td></tr>
</table>



</form>

}}
