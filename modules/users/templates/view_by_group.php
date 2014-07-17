<h1>#group#</h1>

{{if:result:<p>#result#</p>}}

{{if:if_show_admin_link:
<p>
<a href="/users/admin/">Администрирование</a><br>
<a href="/users/groups_view/">Список групп</a><br>
<a href="/users/add/#group_id#/">Добавить пользователя</a>
</p>
}}

{{if:content:<p>#content#</p>}}


<table summary="Users list table">
<tr>
<th>ID</th>
<th>login</th>
<th>Имя</th>
<th>email</th>
<th>Группа</th>
</tr>
#users#
</table>

