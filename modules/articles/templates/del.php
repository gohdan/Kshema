<h1>�������� ������</h1>

{{if:show_admin_link:
<p>
<a href="#inst_root#/articles/admin/">��������� � ���� �����������������</a><br>
<a href="#inst_root#/articles/help#bb_del">�������</a>
</p>
}}

{{if:show_user_articles_link:<p><a href="#inst_root#/articles/view_by_user/">��� ������</a></p>}}

{{if:category:<p><a href="#inst_root#/articles/view_by_category/#category#/">� ���������</a></p>}}

{{if:result:<p>#result#</p>}}

{{if:show_del_form:
<p>�� ������������� ������ ������� ������ <b>#title#</b>?</p>


<form action="#inst_root#/articles/del/#id#/" method="post">

<input type="hidden" name="id" value="#id#">
<input type="submit" name="do_not_del" value="�� �������">
<input type="submit" name="do_del" value="�������">
</form>
}}
