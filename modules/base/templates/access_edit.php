<h1>Назначение прав доступа</h1>

<p><a href="/#module#/admin/">Обратно в администрирование модуля</a></p>

{{if:result:<p>#result#</p>}}

{{if:show_form:

<form action="/#module#/access_edit/" method="post">

<table>
#access_categories#
</table>

<input type="submit" name="do_update" value="Записать">
</form>
}}
