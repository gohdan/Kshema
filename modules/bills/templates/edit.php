<h1>�������������� ����������</h1>

<p>
<a href="/bills/view_by_category/#category#/">������� � ���������</a>
</p>

{{if:show_admin_link:
<p>
<a href="/bills/admin/">���� ����������������� ����������</a><br>
<a href="/bills/add/">�������� ����������</a><br>
<a href="/bills/help#edit">�������</a>
</p>
}}

{{if:show_user_bills_link:<a href="/bills/view_by_user/">��� ����������</a>}}

{{if:content:<p>#content#</p>}}
{{if:result:<p>#result#</p>}}

<form action="/bills/#action#/#id#/" method="post">
<input type="hidden" name="id" value="#id#">
{{if:satellite:<input type="hidden" name="satellite" value="#satellite#">}}
<table summary="bill edit table">
<tr><td>�������� ����������:</td><td><input type="text" name="title" value="#title#"></td></tr>
<tr><td>�������� ��� ���:</td><td><input type="text" name="name" value="#name#"></td></tr>
{{if:categories_select:<tr><td>���������:</td><td><select name="category">#categories_select#</select></td></tr>}}
<tr><td>�����:</td><td><textarea name="full_text">#full_text#</textarea></td></tr>
<tr><td></td><td><input type="submit" name="do_update" value="���������"></td></tr>
</table>
</form>
