<h1>�������� ������������</h1>

<p>
<a href="/users/view_users/">� ������ �������������</a><br>
<a href="/users/help#users_del">�������</a>
</p>

{{if:result:<p>#result#</p>}}

{{if:content:<p>#content#</p>}}

<form action="/users/view_users/" method="post">
<input type="hidden" name="id" value="#id#">
�� ������������� ������ ������� ������������ <b>#name# (#login#)</b>?<br>
<input type="submit" name="do_not_del" value="���">
<input type="submit" name="do_del" value="��">
</form>
