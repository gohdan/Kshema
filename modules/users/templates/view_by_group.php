<h1>#group#</h1>

{{if:result:<p>#result#</p>}}

{{if:if_show_admin_link:
<p>
<a href="/users/admin/">�����������������</a><br>
<a href="/users/groups_view/">������ �����</a><br>
<a href="/users/add/#group_id#/">�������� ������������</a>
</p>
}}

{{if:content:<p>#content#</p>}}


<table summary="Users list table">
<tr>
<th>ID</th>
<th>login</th>
<th>���</th>
<th>email</th>
<th>������</th>
</tr>
#users#
</table>

