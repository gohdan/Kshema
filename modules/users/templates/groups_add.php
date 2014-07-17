<h1>Добавление групп</h1>

<p>
<a href="/users/groups_view/">Вернуться к просмотру групп</a><br>
<a href="/users/help#categories_add">Справка</a>
</p>

{{if:result:<p>#result#</p>}}

{{if:content:<p>#content#</p>}}

<form action="/users/groups_add/" method="post">
Название для вывода пользователю (любые символы):<br>
<input type="text" name="title"><br>

<input type="submit" name="do_add" value="Добавить">
</form>
