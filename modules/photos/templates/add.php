<h1>Добавление фотографии</h1>

<a href="/index.php?module=photos&action=admin">Возврат к администрированию фотографий</a>

<p>#result#</p>

<p>#content#</p>

<form action="/index.php?module=photos&action=add&gallery=#gallery#" method="post" enctype="multipart/form-data">
	<input type="hidden" name="gallery" value="#gallery#">
    Превью: <input type="file" name="thumb"><br>
    Изображение: <input type="file" name="image"><br>
    Название <input type="text" name="name"><br>
    <br>
    Описание:<br>
    <textarea cols="40" rows="10" name="descr"></textarea><br>
    <input type="submit" name="do_add" value="Добавить">
</form>