<h1>Удаление пользователя</h1>

<p>
<a href="/users/view_users/">К списку пользователей</a><br>
<a href="/users/help#users_del">Справка</a>
</p>

{{if:result:<p>#result#</p>}}

{{if:content:<p>#content#</p>}}

<form action="/users/view_users/" method="post">
<input type="hidden" name="id" value="#id#">
Вы действительно хотите удалить пользователя <b>#name# (#login#)</b>?<br>
<input type="submit" name="do_not_del" value="Нет">
<input type="submit" name="do_del" value="Да">
</form>
