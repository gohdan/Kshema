<h1>�������� ���������</h1>

{{if:show_admin_link:
<p>
<a href="/guestbook/admin/">��������� � ���� �����������������</a><br>
<a href="/guestbook/help#bb_del">�������</a>
</p>
}}

<p><a href="/guestbook/view_by_category/#category_link#/">������� � �������� �����</a></p>

<p>�� ������������� ������ ������� ��������� <b>#title#</b>?</p>

#content#

<form action="/guestbook/view_by_category/#category_link#/" method="post">
<input type="hidden" name="category" value="#category#">
<input type="hidden" name="id" value="#id#">
<input type="submit" name="do_not_del" value="�� �������">
<input type="submit" name="do_del" value="�������">
</form>
