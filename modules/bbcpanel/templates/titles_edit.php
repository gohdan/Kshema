<h1>���������� ����������� �������� ��������</h1>

{{if:id:<a href="/bbcpanel/bb_edit/#id#/">������������� �����</a><br>}}

<a href="/bbcpanel/bbs_view_all">������ �����</a><br>

{{if:show_bb_select_form:
<form action="/bbcpanel/titles_edit/" method="post">
<select name="bb">#bbs_select#</select>
<input type="submit" name="do_select_bb" value="�������">
</form>
}}

{{if:show_titles_form:
<form action="/bbcpanel/titles_edit/#id#/" method="post">
<input type="hidden" name="id" value="#id#">
������� ��������, ����� ������� ������<br>
#titles#
<br>
�������� ��������:<br>
<select name="new_category">#categories_select#</select><br>
��������� ��������: <input type="text" size="30" name="new_name"><br>
�������� ��� ������: <input type="text" size="30" name="new_title"><br>

<input type="submit" name="do_update" value="��������">
</form>
}}

