<h1>�������� ������</h1>

<p>
<a href="/users/groups_view/">��������� � ��������� �����</a><br>
<a href="/users/help#categories_del">�������</a>
</p>

<p>�� ������������� ������ ������� ������ <b>#title#</b>?</p>

{{if:content:<p>#content#</p>}}

<form action="/users/groups_view/" method="post">

<input type="hidden" name="id" value="#id#">
<input type="submit" name="do_not_del" value="�� �������">
<input type="submit" name="do_del" value="�������">
</form>
