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
<th style="padding: 5px">ID</th>
<th style="padding: 5px">login</th>
<th style="padding: 5px">Имя</th>
<th style="padding: 5px">email</th>
<th style="padding: 5px">Группа</th>
</tr>
#users#
</table>

