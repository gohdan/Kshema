<h1>���������� �������</h1>

<p>
<a href="/news/admin/">� ����������������� ��������</a><br>
<a href="/news/help#news_add">�������</a>
</p>

<p>
<a href="/uploads/admin/" target="uploads">�������� ����</a>
</p>

<p>#result#</p>

<p>#content#</p>

<form action="/news/add_news/" method="post" enctype="multipart/form-data">
<table summary="News add table">
<tr><td>��������:</td><td><input type="text" name="name"></td></tr>
<tr><td>���� <i>(�� ������� ������!)</i>:</td><td><input type="text" name="date" size="10" align="right" value="#date#"></td></tr>
<tr><td>���������:</td><td><select name="category">#categories_select#</select></td></tr>
<tr><td>�����������-��������:</td><td><input type="file" name="image"></td></tr>
<tr><td>�������� ��������:<br><i>(����-��� ����������� ��� ������� ������� ��������)</i></td></tr>
<tr><td colspan="2"><textarea style="width: 300px; height: 200px;" name="short_descr"></textarea></td></tr>
<tr><td>��������:<br><i>(����� ������ �������� ��� ��������� ������� ��������)</i></td></tr>
<tr><td colspan="2"><textarea cols="50" rows="20" name="descr"></textarea></td></tr>
<tr><td>������ ����� �������:<br><i>(������������ ��� ��������� �������)</i></td></tr>
<tr><td colspan="2"><textarea cols="50" rows="20" name="full_text"></textarea></td></tr>
<tr><td></td><td><input type="submit" name="do_add" value="��������"></td></tr>
</table>
</form>
