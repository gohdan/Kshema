<h1>���������� ������</h1>

<p>#result#</p>

<p>#content#</p>

<form action="/index.php?module=shop&action=order_send" method="post">
<table class="tbl_cart">
<tr><th>���:</th><th colspan1="2"><b>#sur_name#&nbsp;#first_name#&nbsp;#second_name#</b></th></tr>
<tr><th>������:</th><td>#country#</td></tr>
<tr><th>������:</th><td>#post_code#</td></tr>
<tr><th>�������:</th><td>#area#</td></tr>
<tr><th>��������� �����:</th><td>#city#</td></tr>
<tr><th>�����/���/��������:</th><td>#address#</td></tr>
<tr><td><a href="/index.php?module=users&action=profile_edit">������������� ������</a></td></tr>
{{if:show_form:<tr><td><input type="submit" class="button" value="������� �� ���� �����"></td></tr>}}
</table>
</form>