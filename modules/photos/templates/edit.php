<h1>Редактирование фотографии</h1>

<a href="/index.php?module=photos&action=view_gallery&gallery=#gallery_id#">Вернуться к просмотру галереи</a>

<p>#result#</p>

<p>#content#</p>

<form action="/index.php?module=photos&action=edit" method="post"  enctype="multipart/form-data">
    <input type="hidden" name="id" value="#id#">
	<input type="hidden" name="old_image" value="#image#">
    <input type="hidden" name="old_thumb" value="#thumb#">
    Название <input type="text" name="name" value="#name#"><br>
    Галерея: #gallery#<br>
    Описание:<br>
    <textarea cols="40" rows="10" name="descr">#descr#</textarea><br>
    <img src="#thumb#"><br>
	Новое превью: <input type="file" name="thumb"><br>
	<img src="#image#"><br>
	Новое изображение: <input type="file" name="image"><br>
    <input type="submit" name="do_update" value="Записать">
</form>