<h1>�������������� ����������</h1>


{{if:show_admin_link:
<p>
<a href="/bills/admin/">���� ����������������� ����������</a><br>
<a href="/bills/add/">�������� ����������</a><br>
<a href="/bills/help#edit">�������</a>
</p>
}}

{{if:content:<p>#content#</p>}}

{{if:result:<p>#result#</p>}}


<form action="/bills/moderate_edit/#id#/{{if:satellite:satellite_#satellite#/}}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="#id#">

<table summary="articles edit table">
<tr><td>��������:</td><td><input type="text" name="title" value="#title#"></td></tr>
<tr><td>�������� ��� ���:</td><td><input type="text" name="name" value="#name#"></td></tr>
<tr><td>���������:</td><td><select name="category">#categories_select#</select></td></tr>
<tr><td>��������:</td><td><textarea cols="40" rows="20" name="descr">#descr#</textarea></td></tr>
<tr><td>�����:</td><td><textarea cols="40" rows="20" name="full_text">#full_text#</textarea></td></tr>

<tr><td></td><td><input type="submit" name="do_update" value="��������"></td></tr>
</table>
	
</form>
