<h1>�������������� ������</h1>

<p>#content#</p>

<p>#result#</p>

<p>
<a href="/index.php?module=calc_adv&action=view_cities">������� � ������ �������</a>
</p>

<form action="/index.php?module=calc_adv&action=city_edit&city=#id#>" method="post">
��������: <input type="text" name="title" value="#title#"><br>
��������:<br>
<textarea name="descr" rows="30" cols="40">#descr#</textarea><br>
��������� �������:
<table>
<tr>
<td><input type="radio" name="calc_type" value="0" #calc_prime_checked#> �� ������:</td>
<td><input type="radio" name="calc_type" value="1" #calc_time_checked#> �� �������</td>
</tr>
<tr>
<td>
�����: <input type="text" name="price_prime" size="4" value="#price_prime#"> ���.<br>
�� �����: <input type="text" name="price_noprime" size="4" value="#price_noprime#"> ���.
</td>
<td>
<input type="text" name="time_0" size="9" value="#times_0#"> = <input type="text" name="time_price_0" size="5" value="#time_prices_0#"> ���.<br>
<input type="text" name="time_1" size="9" value="#times_1#"> = <input type="text" name="time_price_1" size="5" value="#time_prices_1#"> ���.<br>
<input type="text" name="time_2" size="9" value="#times_2#"> = <input type="text" name="time_price_2" size="5" value="#time_prices_2#"> ���.<br>
<input type="text" name="time_3" size="9" value="#times_3#"> = <input type="text" name="time_price_3" size="5" value="#time_prices_3#"> ���.<br>
<input type="text" name="time_4" size="9" value="#times_4#"> = <input type="text" name="time_price_4" size="5" value="#time_prices_4#"> ���.<br>
<input type="text" name="time_5" size="9" value="#times_5#"> = <input type="text" name="time_price_5" size="5" value="#time_prices_5#"> ���.<br>
<input type="text" name="time_6" size="9" value="#times_6#"> = <input type="text" name="time_price_6" size="5" value="#time_prices_6#"> ���.<br>
<input type="text" name="time_7" size="9" value="#times_7#"> = <input type="text" name="time_price_7" size="5" value="#time_prices_7#"> ���.<br>
<input type="text" name="time_8" size="9" value="#times_8#"> = <input type="text" name="time_price_8" size="5" value="#time_prices_8#"> ���.<br>
<input type="text" name="time_9" size="9" value="#times_9#"> = <input type="text" name="time_price_9" size="5" value="#time_prices_9#"> ���.<br>
<input type="text" name="time_10" size="9" value="#times_10#"> = <input type="text" name="time_price_10" size="5" value="#time_prices_10#"> ���.<br>
<input type="text" name="time_11" size="9" value="#times_11#"> = <input type="text" name="time_price_11" size="5" value="#time_prices_11#"> ���.<br>

</td>
</tr>
</table>
�������� �����������:<br>
<table>
#season_coefs_form#
</table>

����������� �������������: <input type="text" size="3" name="noresident_coef" value="#noresident_coef#"><br>
��� ������:<br>
<input type="radio" name="discount_type" value="0" #discount_time_checked#> �� ������� (����� ���������� ���������� ������)<br>
<input type="radio" name="discount_type" value="1" #discount_price_checked#> �� ��������� (����� ���������� ���������� ������)<br>
<!--
�����, � �������� ���������� ������: <input type="text" name="discount_from" value="<?=$city['discount_from']?>"><br>
������ ������, %: <input type="text" name="discount" value="<?=$city['discount']?>"><br>
-->
�����, � �������� ���������� ������: <input type="text" name="discount_0" size="9" value="#discount_0#"> = <input type="text" name="discount_price_0" size="5" value="#discount_price_0#"> %<br>
�����, � �������� ���������� ������: <input type="text" name="discount_1" size="9" value="#discount_1#"> = <input type="text" name="discount_price_1" size="5" value="#discount_price_1#"> %<br>
�����, � �������� ���������� ������: <input type="text" name="discount_2" size="9" value="#discount_2#"> = <input type="text" name="discount_price_2" size="5" value="#discount_price_2#"> %<br>
�����, � �������� ���������� ������: <input type="text" name="discount_3" size="9" value="#discount_3#"> = <input type="text" name="discount_price_3" size="5" value="#discount_price_3#"> %<br>
�����, � �������� ���������� ������: <input type="text" name="discount_4" size="9" value="#discount_4#"> = <input type="text" name="discount_price_4" size="5" value="#discount_price_4#"> %<br>
�����, � �������� ���������� ������: <input type="text" name="discount_5" size="9" value="#discount_5#"> = <input type="text" name="discount_price_5" size="5" value="#discount_price_5#"> %<br>
�����, � �������� ���������� ������: <input type="text" name="discount_6" size="9" value="#discount_6#"> = <input type="text" name="discount_price_6" size="5" value="#discount_price_6#"> %<br>
�����, � �������� ���������� ������: <input type="text" name="discount_7" size="9" value="#discount_7#"> = <input type="text" name="discount_price_7" size="5" value="#discount_price_7#"> %<br>
�����, � �������� ���������� ������: <input type="text" name="discount_8" size="9" value="#discount_8#"> = <input type="text" name="discount_price_8" size="5" value="#discount_price_8#"> %<br>
�����, � �������� ���������� ������: <input type="text" name="discount_9" size="9" value="#discount_9#"> = <input type="text" name="discount_price_9" size="5" value="#discount_price_9#"> %<br>
�����, � �������� ���������� ������: <input type="text" name="discount_10" size="9" value="#discount_10#"> = <input type="text" name="discount_price_10" size="5" value="#discount_price_10#"> %<br>

<input type="submit" class="button" name="do_save" value="���������">
</form>
