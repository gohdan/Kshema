<h1>Редактирование файла</h1>

{{if:category:
<p>
<a href="#inst_root#/files/view_by_category/#category_name#/">Обратно в категорию</a>
</p>
}}

{{if:show_admin_link:
<p>
<a href="#inst_root#/files/admin/">Меню администрирования файлов</a><br>
<a href="#inst_root#/files/add/">Добавить файл</a><br>
<a href="#inst_root#/files/help#edit">Справка</a>
</p>
}}

{{if:content:<p>#content#</p>}}

{{if:result:<p>#result#</p>}}


<form action="#inst_root#/files/edit/#id#/{{if:satellite:satellite_#satellite#/}}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="#id#">
<!--	
    <input type="hidden" name="old_image" value="#image#">
    <input type="hidden" name="old_doc" value="#doc#">

    <img src="#image#"><br>
    Новое изображение-описание: <input type="file" name="image">
    <br>
	Прикреплённый документ: #doc#<br>
	Прикрепить другой документ: <input type="file" name="doc">
-->



<table summary="files edit table">
<tr><td>Название:</td><td><input type="text" name="title" value="#title#"></td></tr>
<tr><td>Название для ЧПУ:</td><td><input type="text" name="name" value="#name#"></td></tr>
<tr><td>Категория:</td><td><select name="category">#categories_select#</select></td></tr>
<tr><td>Описание:</td><td><textarea cols="40" rows="20" name="descr">#descr#</textarea></td></tr>
<tr><td>Путь:</td><td>#file#</td></tr>
<tr><td></td><td><input type="submit" name="do_update" value="Записать"></td></tr>
</table>
	
</form>
