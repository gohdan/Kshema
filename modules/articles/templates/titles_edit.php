<h1>���������� ����������� �������� ��������</h1>

{{if:satellite_id:<a href="#inst_root#/articles/admin_satellite/#satellite_id#/">� ���� ����������������� ���������</a><br>}}

<form action="#inst_root#/articles/titles_edit/satellite_#satellite_id#/" method="post">
<input type="hidden" name="id" value="#satellite_id#">
������� �������� ��� ������, ����� ������� ������<br>
#titles#
<br>
�������� ��������:<br>
<select name="new_category">#categories_select#</select><br>
��������� ��������: <input type="text" size="30" name="new_name"><br>
�������� ��� ������: <input type="text" size="30" name="new_title"><br>

<input type="submit" name="do_update" value="��������">
</form>

