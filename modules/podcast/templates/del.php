<h1>�������� ������� ��������</h1>

<p>
<a href="#inst_root#/podcast/admin/">��������� � ���� �����������������</a><br>
<a href="#inst_root#/podcast/view_by_category/1/">������ ��������</a><br>
</p>

{{if:result:<p>#result#</p>}}

{{if:show_del_form:
<p>�� ������������� ������ ������� ������ <b>"#title#"</b>?</p>


<form action="#inst_root#/podcast/del/#id#/" method="post">

<input type="hidden" name="id" value="#id#">
<input type="submit" name="do_not_del" value="�� �������">
<input type="submit" name="do_del" value="�������">
</form>
}}
