<h1>Добавление файлов</h1>

{{if:result:<p>#result#</p>}}

{{if:show_admin_link:
<a href="/files/admin/">К администрированию файлов</a>
}}

{{if:category:<p><a href="/files/">В категории</a></p>}}

<form action="#inst_root#/files/add/" method="post" enctype="multipart/form-data">
<input type="hidden" name="required_fields[]" value="title">
<table summary="files add table">
<tr><td>Файл*:</td><td><input type="file" name="file"></td></tr>
<tr><td>Название*:</td><td><input type="text" name="title" value="#title#"></td></tr>
<tr><td>Название для ЧПУ:</td><td><input type="text" name="name" value="#name#"></td></tr>
<tr><td>Категория:</td><td><select name="category">#categories_select#</select></td></tr>
<tr><td>Описание:</td><td><textarea cols="20" rows="10" name="descr">#descr#</textarea></td></tr>
{{if:show_captcha:<tr><td><img src="#inst_root#/libs/kcaptcha/index.php?#session_name#=#session_id#"></td><td>Проверочный код слева:<br><input type="text" name="keystring"></td></tr>}}
<tr><td></td><td><input type="submit" name="do_add" value="Добавить"></td></tr>
</table>
</form>
