<h1>�������</h1>

<p>#result#</p>

<p>#content#</p>

{{if:show_cart:
<table class="tbl_cart">
<tr><th></th><th>��������</th><th>����</th><th>����������</th><th>�������</th></tr>
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

<form action="/index.php?module=shop&action=order_create" method="post" style="display:inline"><input type="submit" class="button" value="�������� �����"></form>
}}