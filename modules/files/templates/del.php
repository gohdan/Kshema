<h1>Удаление файла</h1>

{{if:show_admin_link:
<p>
<a href="#inst_root#/files/admin/">Вернуться в меню администрирования</a><br>
<a href="#inst_root#/files/help#bb_del">Справка</a>
</p>
}}

{{if:category:<p><a href="#inst_root#/files/view_by_category/#category#/">В категорию</a></p>}}

{{if:result:<p>#result#</p>}}

{{if:show_del_form:
<p>Вы действительно хотите удалить файл <b>#title#</b>?</p>


<form action="#inst_root#/files/del/#id#/" method="post">

<input type="hidden" name="id" value="#id#">
<input type="submit" name="do_not_del" value="Не удалять">
<input type="submit" name="do_del" value="Удалить">
</form>
}}
