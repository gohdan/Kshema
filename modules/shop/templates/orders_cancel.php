<h1>������ ������</h1>

{{if:admin_link:<p><a href="/index.php?module=shop&action=orders_view_all">� ��������� �������</a></p>}}

<hr>

<p>�� ������������� ������ �������� ����� <b>#id#</b>?</b>

<form action="/index.php?module=shop&action=orders_view&order=#id#" method="post">
<input type="hidden" name="id" value="#id#">
<input type="submit" name="do_not_cancel" value="���">
<input type="submit" name="do_cancel" value="��">
</form>