<h1>�������� ������</h1>

{{if:show_admin_link:
<p>
<a href="#inst_root#/articles/admin/">��������� � ���� �����������������</a><br>
<a href="#inst_root#/articles/help#bb_del">�������</a>
</p>
}}


{{if:result:<p>#result#</p>}}

{{if:show_del_form:
<p>�� ������������� ������ ������� ������ <b>#title#</b>?</p>


<form action="#inst_root#/articles/moderate_del/#id#/{{if:satellite:satellite_#satellite#/}}" method="post">

<input type="hidden" name="id" value="#id#">
<input type="submit" name="do_not_del" value="�� �������">
<input type="submit" name="do_del" value="�������">
</form>
}}
