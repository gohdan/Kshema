<h1>�������� ������</h1>

<p>#result#</p>

<p>#content#</p>

{{if:admin_link:<p><a href="/index.php?module=shop&action=orders_view_all">� ��������� �������</a></p>}}

<p>
<b>����� ����� #id#</b><br>
<b>������: #order_status#</b><br>
<b>������: #date#</b>
</p>

{{if:cancel:<p><a href="/index.php?module=shop&action=orders_cancel&orders=#id#">�������� �����</a></p>}}

{{if:delete:<p><a href="/index.php?module=shop&action=orders_del&orders=#id#">������� �����</a></p>}}
{{if:change:
<form action="/index.php?module=shop&action=orders_view&order=#id#" method="post">
<input type="hidden" name="id" value="#id#">
��������� ������:
<select name="status">
#statuses#

<input type="submit" name="do_change_status" value="�������">
</form>
</select>}}
<table class="tbl_cart">
<tr>
<th></th>
<th style="padding: 0px 3px 0px 3px">��������</th>
<th style="padding: 0px 3px 0px 3px">����</th>
<th style="padding: 0px 3px 0px 3px">����������</th>
</tr>
#cart_goods#
</table>

<table class="props">
<tr>
<th>���������� �������:</th>
<td align="right">#sum_qty#</td>
</tr>
<tr>
<th>���</th>
<td align="right">#sum_weight#</td>
</tr>
<tr>
<th>��������� �������:</th>
<td align="right">#sum_price# ���.</th>
</tr>
<tr>
<th>��������� ��������:</th>
<td align="right">#sum_delivery# ���.</td>
</tr>
<tr>
<th><b>��������� � ���������:</b></th>
<td align="right"><b>#sum_cost# ���.</b></td>
</tr>
</table>

<h2>�����</h2>
<table class="tbl_form">
<tr><td>�������:</td><td>#sur_name#</td></tr>
<tr><td>���</td><td>#first_name#</td></tr>
<tr><td>��������:</td><td>#second_name#</td></tr>
<tr><td>������:</td><td>������</td></tr>
<tr><td>������:</td><td>#post_code#</td></tr>
<tr><td>�������:</td><td>#area#</td></tr>
<tr><td>�����:</td><td>#city#</td></tr>
<tr><td>�����/���/��������:</td><td>#address#</td>
</tr>
</table>
