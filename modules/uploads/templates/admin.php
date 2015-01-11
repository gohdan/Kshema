<h1>Закачка файлов</h1>

#content#

<p>
<a href="/modules/admin/">Возврат к списку модулей</a><br>
<a href="/uploads/help/">Справка</a>
</p>

<form action="/uploads/admin/" method="post" enctype="multipart/form-data">
	Что закачиваем:<br>
	<input type="radio" name="type" value="uploads"{{if:type_uploads: checked}}>Просто файл<br>
	<input type="radio" name="type" value="news"{{if:type_news: checked}}>Изображение для использования в новостях<br>
	<input type="radio" name="type" value="articles"{{if:type_articles: checked}}>Изображение для использования в статьях<br>
	<input type="radio" name="type" value="banners"{{if:type_banners: checked}}>Баннер<br>
    Файл: <input type="file" name="image">
    <input type="submit" name="do_upload" value="Закачать">
</form>

<h2>Администрирование базы данных закачек</h2>

<p>
<a href="/uploads/create_tables/">Создать таблицы базы данных</a><br>
<a href="/uploads/drop_tables/">Уничтожить таблицы базы данных</a><br>
<a href="/uploads/update_tables/">Обновить таблицы базы данных</a>
</p>
