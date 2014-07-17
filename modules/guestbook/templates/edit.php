<h1>Редактирование сообщения</h1>

<p>
<a href="/guestbook/view_by_category/#category_link#/">Обратно в категорию</a>
</p>

{{if:show_admin_link:
<p>
<a href="/guestbook/admin/">Меню администрирования гостевых книг</a><br>
<a href="/guestbook/add/">Добавить сообщение</a><br>
<a href="/guestbook/help#edit">Справка</a>
</p>
}}

{{if:content:<p>#content#</p>}}
{{if:result:<p>#result#</p>}}

<form action="/guestbook/edit/#id#/" method="post">
<input type="hidden" name="id" value="#id#">
<input type="hidden" name="category" value="#category#">

<table summary="message edit table">
<tr><td>Имя:</td><td><input type="text" name="name" value="#name#"></td></tr>
<tr><td>Способ связи:</td><td><input type="text" name="contact" value="#contact#"></td></tr>
<tr><td>Заголовок:</td><td><input type="text" name="title" value="#title#"></td></tr>
<tr><td>Текст:</td><td><textarea name="text" style="width: 400px; height: 300px">#text#</textarea></td></tr>
<tr><td></td><td><input type="submit" name="do_update" value="Сохранить"></td></tr>
</table>
</form>
