<h1>�������������� ���������</h1>

<p>
<a href="/bbcpanel/bbs_view_all/">������ ����������</a>
</p>

{{if:result:<p>#result#</p>}}

{{if:show_admin_link:
<p>
<a href="/bbcpanel/admin/">���� ����������������� ����������</a><br>
<a href="/bbcpanel/bb_add/">�������� ��������</a><br>
</p>
}}

<p>
<a href="/bbcpanel/tparts_edit/#id#/">������������� ����� ��������</a><br>
<a href="/bbcpanel/update_all/#id#/">�������� ����������� ���</a>
</p>

<p>
#modules#
</p>

{{if:content:<p>#content#</p>}}
{{if:result:<p>#result#</p>}}

<form action="/bbcpanel/bb_edit/#id#/" method="post">
<input type="hidden" name="id" value="#id#">
<input type="hidden" name="name" value="">
<table summary="bb edit table">
<tr><td>�������� ��� ������������:</td><td><input type="text" name="title" value="#title#"></td></tr>
<tr><td>��������:</td><td><select name="category">#categories_select#</select></td></tr>
<tr><td>URL:</td><td><input type="text" name="url" value="#url#"></td></tr>
<tr><td>�������, � ������� ����������</td><td><input type="text" name="instroot" value="#instroot#"></td></tr>
<tr><td></td><td><input type="submit" name="do_update" value="���������"></td></tr>
</table>
</form>
