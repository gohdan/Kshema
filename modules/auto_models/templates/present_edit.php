<h1>Редактирование автомобиля в наличии</h1>

{{if:result:<p>#result#</p>}}

{{if:show_admin_link:
<p><a href="/auto_models/admin/">К администрированию моделей автомобилей</a></p>
}}

<p><a href="/auto_models/present_view/">К списку</a></p>

{{if:show_form:

<form action="#inst_root#/auto_models/present_edit/#id#/" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="#id#">
<input type="hidden" name="category" value="1">
<input type="hidden" name="old_image" value="#image#">

<input type="hidden" name="if_with_equip" value="0">

<table summary="present auto edit table">
<tr><td>Новое изображение:</td><td><input type="file" name="image"></td></tr>
<tr><td>Название:</td><td><input type="text" name="title" value="#title#"></td></tr>
<tr><td>Модель:</td><td><select name="model">#models_select#</select></td></tr>
<tr><td>Двигатель/КПП:</td><td><input type="text" name="engine" value="#engine#"></td></tr>
<tr><td>Салон:</td><td><input type="text" name="salon" value="#salon#"></td></tr>
<tr><td>Производство:</td><td><input type="text" name="producer" value="#producer#"></td></tr>
<tr><td>Комплектация:</td><td><input type="text" name="complectation" value="#complectation#"></td></tr>
<tr><td>Цена:</td><td><input type="text" name="price" value="#price#" size="10"></td></tr>
<tr><td>Год:</td><td><input type="text" name="year" value="#year#" size="4"></td></tr>
<tr><td>Доп. оборудование:</td><td><input type="checkbox" name="if_with_equip" value="1"{{if:if_with_equip: checked}}></td></tr>


<tr><td></td><td><input type="submit" name="do_update" value="Сохранить"></td></tr>
</table>
</form>
}}
