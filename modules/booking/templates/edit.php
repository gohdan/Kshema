<h1>����� #id#</h1>

<p>
<a href="/booking/admin/">���� ����������������� �������</a><br>
<a href="/booking/orders_list/">������ �������</a><br>
</p>


{{if:content:<p>#content#</p>}}

<form action="/booking/edit/#id#/" method="post">
<input type="hidden" name="id" value="#id#">
<input type="hidden" name="if_children" value="0">
<input type="hidden" name="if_extra_bed" value="0">
<input type="hidden" name="if_transfer" value="0">

<table summary="Booking edit table" class="booking_edit_table">
<tr><td>����� ������</td><td>#id#</td></tr>
<tr><td>���� ������</td><td><input type="text" name="date" value="#date#" id="date" size="10"><hr></td></tr>
<tr><td>�������</td><td><select name="room"><option value="0">-</option>#order_edit_rooms_select#</select></td></tr>
<tr><td>���� ���������</td><td><input type="text" name="date_from" value="#date_from#" id="date_from" size="10"></td></tr>
<tr><td>����� ���������</td><td><input type="text" name="time_from" value="#time_from#" size="5"></td></tr>
<tr><td>���� ���������</td><td><input type="text" name="date_to" value="#date_to#" id="date_to" size="10"></td></tr>
<tr><td>����� ���������</td><td><input type="text" name="time_to" value="#time_to#" size="5"></td></tr>
<tr><td>����� ����</td><td><input type="text" name="days" value="#days#" id="days_qty" size="2"> <a href="#" onClick="javascript:days_count()">�����������</a></td></tr>
<tr><td>������</td><td><input type="text" name="price" value="#price#" id="price" size="4"></td></tr>
<tr><td>���</td><td><input type="text" name="name" value="#name#"></td></tr>
<tr><td>�������</td><td><input type="text" name="surname" value="#surname#"></td></tr>
<tr><td>�������</td><td><input type="text" name="phone" value="#phone#"></td></tr>
<tr><td>E-mail</td><td><input type="text" name="email" value="#email#"></td></tr>
<tr><td>������</td><td><input type="text" name="country" value="#country#"></td></tr>
<tr><td>�������</td><td><select name="variant">
<option value="1"{{if:variant_1_selected: selected}}>Standard</option>
<option value="2"{{if:variant_2_selected: selected}}>Deluxe</option>
<option value="3"{{if:variant_3_selected: selected}}>Apartments</option>
</select></td></tr>
<tr><td>���������� �������</td><td><input type="text" name="rooms_qty" value="#rooms_qty#" size="2"></td></tr>
<tr><td>���������� ��������</td><td><input type="text" name="adults_qty" value="#adults_qty#" size="2"></td></tr>
<tr><td>�����������</td><td><input type="text" name="comment" value="#comment#"></td></tr>
<tr><td>���� �� 12-�� ���</td><td><input type="checkbox" name="if_children" value="1"{{if:if_children: checked}}</td></tr>
<tr><td>�������������� �������</td><td><input type="checkbox" name="if_extra_bed" value="1"{{if:if_extra_bed: checked}}></td></tr>
<tr><td>�������� �� ���������</td><td><input type="checkbox" name="if_transfer" value="1"{{if:if_transfer: checked}}</td></tr>
<tr><td>���������� ���������</td><td><input type="text" name="breakfast_qty" value="#breakfast_qty#" size="2"></td></tr>
<tr><td>�����</td><td><input type="text" name="cost" value="#cost#" id="cost" size="5"> <a href="#" onClick="javascript:cost_count()">�����������</a></td></tr>
<tr><td>���������� ������</td><td><input type="text" name="passport" value="#passport#"></td></tr>
<tr><td>��� ������</td><td><input type="text" name="payment_type" value="#payment_type#"></td></tr>
<tr><td>����������</td><td><input type="text" name="prepayment" value="#prepayment#"></td></tr>
<tr><td>�������</td><td><input type="text" name="leftover" value="#leftover#" size="5"></td></tr>
<tr><td>������ ������</td><td><input type="text" name="payment_status" value="#payment_status#"></td></tr>
<tr><td>��������</td><td><input type="text" name="manager" value="#manager#"></td></tr>
<tr><td>���������</td><td><input type="text" name="dealer" value="#dealer#"></td></tr>
<tr><td></td><td><input type="submit" name="do_update" value="���������"></td></tr>
</table>
</form>
