<h1>���������� �������</h1>

<p>
<a href="/banners/admin/">� ����������������� ��������</a><br>
{{if:category:<a href="/banners/view_by_category/#category#/">� ���������</a><br>}}
<a href="/banners/help#banners_add">�������</a>
</p>

{{if:result:<p>#result#</p>}}

{{if:content:<p>#content#</p>}}

<form action="/banners/add_banners/" method="post" enctype="multipart/form-data">
<table summary="Banner add table">
<tr><td>��������� ��������:</td><td><input type="text" name="name"></td></tr>
<tr><td>�������� ��� ������ ������������:</td><td><input type="text" name="title" size="40">
<tr><td>���������:</td><td><select name="category">#categories_select#</select></td></tr>
<tr><td>����:</td><td><input type="file" name="image"></td></tr>
<tr><td>���:</td><td><select name="type">
<option value="img">�����������</option>
<option value="bg">������� �����������</option>
<option value="swf">Flash</option>
</select></td></tr>
<tr><td>��������� Flash:</td><td><input name="params" type="text"></td></tr>
<tr><td>����� ���������� (CSS):</td><td><input name="class" type="text"></td></tr>
<tr><td>��������:</td><td><input name="descr" type="text"></td></tr>
<tr><td>Alt:</td><td><input name="alt" type="text"></td></tr>
<tr><td>������:</td><td><input name="width" type="text"></td></tr>
<tr><td>������:</td><td><input name="height" type="text"></td></tr>
<tr><td>������:</td><td><input name="link" type="text" size="40"></td></tr>
<tr><td>(<a href="/uploads/admin/" target="_upload">��������� ����</a>)</td></tr>
<tr><td></td><td><input type="submit" name="do_add" value="��������"></td></tr>
</table>
</form>
