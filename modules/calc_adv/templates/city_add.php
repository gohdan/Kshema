<h1>���������� ������ ������</h1>

<p>#content#</p>

<p>#result#</p>

<p>
<a href="/index.php?module=calc_adv&action=view_cities">������� � ������ �������</a>
</p>

<form action="/index.php?module=calc_adv&action=city_add" method="post">
��������: <input type="text" name="title"><br>
��������:<br>
<textarea name="descr" rows="30" cols="40"></textarea><br>
��������� �������:
<table>
<tr>
<td><input type="radio" name="calc_type" value="0" checked> �� ������:</td>
<td><input type="radio" name="calc_type" value="1"> �� �������</td>
</tr>
<tr>
<td>
�����: <input type="text" name="price_prime" size="4"> ���.<br>
�� �����: <input type="text" name="price_noprime" size="4"> ���.
</td>
<td>
�����: <input type="text" name="time_0" size="9"> = <input type="text" name="time_price_0" size="5"> ���.<br>
�����: <input type="text" name="time_1" size="9"> = <input type="text" name="time_price_1" size="5"> ���.<br>
�����: <input type="text" name="time_2" size="9"> = <input type="text" name="time_price_2" size="5"> ���.<br>
�����: <input type="text" name="time_3" size="9"> = <input type="text" name="time_price_3" size="5"> ���.<br>
�����: <input type="text" name="time_4" size="9"> = <input type="text" name="time_price_4" size="5"> ���.<br>
�����: <input type="text" name="time_5" size="9"> = <input type="text" name="time_price_5" size="5"> ���.<br>
�����: <input type="text" name="time_6" size="9"> = <input type="text" name="time_price_6" size="5"> ���.<br>
�����: <input type="text" name="time_7" size="9"> = <input type="text" name="time_price_7" size="5"> ���.<br>
�����: <input type="text" name="time_8" size="9"> = <input type="text" name="time_price_8" size="5"> ���.<br>
�����: <input type="text" name="time_9" size="9"> = <input type="text" name="time_price_9" size="5"> ���.<br>
�����: <input type="text" name="time_10" size="9"> = <input type="text" name="time_price_10" size="5"> ���.<br>
�����: <input type="text" name="time_11" size="9"> = <input type="text" name="time_price_11" size="5"> ���.<br>

</td>
</tr>
</table>
�������� �����������:<br>
<table>
#month_coefs_form#
</table>
����������� �������������: <input type="text" size="3" name="noresident_coef"><br>
��� ������:<br>
<input type="radio" name="discount_type" value="0" checked> �� ������� (����� ���������� ���������� ������)<br>
<input type="radio" name="discount_type" value="1"> �� ��������� (����� ���������� ���������� ������)<br>
<!--
�����, � �������� ���������� ������: <input type="text" name="discount_from"><br>
������ ������, %: <input type="text" name="discount"><br>
-->
�����, � �������� ���������� ������: <input type="text" name="discount_0" size="9"> = <input type="text" name="discount_price_0" size="5"> %<br>
�����, � �������� ���������� ������: <input type="text" name="discount_1" size="9"> = <input type="text" name="discount_price_1" size="5"> %<br>
�����, � �������� ���������� ������: <input type="text" name="discount_2" size="9"> = <input type="text" name="discount_price_2" size="5"> %<br>
�����, � �������� ���������� ������: <input type="text" name="discount_3" size="9"> = <input type="text" name="discount_price_3" size="5"> %<br>
�����, � �������� ���������� ������: <input type="text" name="discount_4" size="9"> = <input type="text" name="discount_price_4" size="5"> %<br>
�����, � �������� ���������� ������: <input type="text" name="discount_5" size="9"> = <input type="text" name="discount_price_5" size="5"> %<br>
�����, � �������� ���������� ������: <input type="text" name="discount_6" size="9"> = <input type="text" name="discount_price_6" size="5"> %<br>
�����, � �������� ���������� ������: <input type="text" name="discount_7" size="9"> = <input type="text" name="discount_price_7" size="5"> %<br>
�����, � �������� ���������� ������: <input type="text" name="discount_8" size="9"> = <input type="text" name="discount_price_8" size="5"> %<br>
�����, � �������� ���������� ������: <input type="text" name="discount_9" size="9"> = <input type="text" name="discount_price_9" size="5"> %<br>
�����, � �������� ���������� ������: <input type="text" name="discount_10" size="9"> = <input type="text" name="discount_price_10" size="5"> %<br>

<input type="submit" class="button" name="do_add" value="��������">
</form>
