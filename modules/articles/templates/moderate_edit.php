<h1>�������������� ������</h1>


{{if:show_admin_link:
<p>
<a href="#inst_root#/articles/admin/">���� ����������������� ������</a><br>
<a href="#inst_root#/articles/add/">�������� ������</a><br>
<a href="#inst_root#/articles/help#edit">�������</a>
</p>
}}

{{if:content:<p>#content#</p>}}

{{if:result:<p>#result#</p>}}


<form action="#inst_root#/articles/moderate_edit/#id#/{{if:satellite:satellite_#satellite#/}}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="#id#">
<!--	
    <input type="hidden" name="old_image" value="#image#">
    <input type="hidden" name="old_doc" value="#doc#">

    <img src="#image#"><br>
    ����� �����������-��������: <input type="file" name="image">
    <br>
	������������ ��������: #doc#<br>
	���������� ������ ��������: <input type="file" name="doc">
-->

<table summary="articles edit table">
<tr><td>��������:</td><td><input type="text" name="title" value="#title#"></td></tr>
<tr><td>�������� ��� ���:</td><td><input type="text" name="name" value="#name#"></td></tr>
<tr><td>���������:</td><td><select name="category">#categories_select#</select></td></tr>
<tr><td>��������:</td><td><textarea cols="40" rows="20" name="descr">#descr#</textarea></td></tr>
<tr><td>�����:</td><td><textarea cols="40" rows="20" name="full_text">#full_text#</textarea></td></tr>

<tr><td></td><td><input type="submit" name="do_update" value="��������"></td></tr>
</table>
	
</form>
