<h1>�������������� ���������</h1>

<p>
<a href="/index.php?module=portfolio&amp;action=view_categories">��������� ���������</a><br>
<a href="/index.php?module=portfolio&amp;action=help#portfolio_edit">�������</a>
</p>

{{if:result:<p>#result#</p>}}

{{if:content:<p>#content#</p>}}

<form action="/index.php?module=portfolio&amp;action=edit" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="#id#">
<input type="hidden" name="old_image" value="#image#">

<table summary="portfolio edit table">
<tr><td>��������:</td><td><input type="text" name="name" value="#name#"></td></tr>
<tr><td>���� <i>(�� ������� ������!)</i>:</td><td><input type="text" name="date" size="10" align="right" value="#date#"></td></tr>
<tr><td>���������:</td><td><select name="category">#categories_select#</select></td></tr>
<tr><td colspan="2"><img src="#image#"></td></tr>
<tr><td>����� �����������-��������:</td><td><input type="file" name="image"></td></tr>
<tr><td>�������� ��������:</td></tr>
<tr><td colspan="2"><textarea style="width: 300px; height: 200px;" name="short_descr">#short_descr#</textarea></td></tr>
<tr><td>��������:</td></tr>
<tr><td colspan="2"><textarea cols="50" rows="20" name="descr">#descr#</textarea></td></tr>
<tr><td>�����:</td></tr>
<tr><td colspan="2"><textarea cols="50" rows="20" name="full_text">#full_text#</textarea></td></tr>
<tr><td></td><td><input type="submit" name="do_update" value="��������"></td></tr>
</table>
</form>
