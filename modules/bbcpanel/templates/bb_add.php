<h1>���������� ���������</h1>

#content#

{{if:result:<p>#result#</p>}}

<p>
<a href="/bbcpanel/bbs_view_all/">������ ����������</a><br>
</p>


<form action="/bbcpanel/bb_add/" method="post">
<input type="hidden" name="name" value="">
<table summary="bbcpanel add table">
<tr><td>��������:</td><td><input type="text" name="title"></td></tr>
<tr><td>��������:</td><td><select name="category">#categories_select#</select></td></tr>
<tr><td>URL:</td><td><input type="text" name="url"></td></tr>
<tr><td>�������, � ������� ����������:</td><td><input type="text" name="instroot"></td></tr>
<tr><td></td><td><input type="submit" name="do_add" value="��������"></td></tr>
</table>
</form>
