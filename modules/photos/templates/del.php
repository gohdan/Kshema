<h1>Удаление фотографии</h1>

<p>
<a href="/index.php?module=photos&action=view_gallery&gallery=#gallery#">Вернуться к просмотру галереи</a>
</p>

<p>Вы действительно хотите удалить фотографию <b>#name#</b>?</p>

<p>#result#</p>

<p>#content#</p>

<form action="/index.php?module=photos&action=view_gallery&gallery=#gallery#" method="post">

<input type="hidden" name="id" value="#id#">
<input type="submit" name="do_not_del" value="Не удалять">
<input type="submit" name="do_del" value="Удалить">
</form>
