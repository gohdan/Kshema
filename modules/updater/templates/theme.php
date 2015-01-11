<h1>#heading#</h1>

<p>
<a href="/users/profile_view/">Ваш профиль</a>
{{if:show_admin_link:<br><a href="/updater/admin/">Обратно в меню администрирования</a>}}
</p>

{{if:theme:<p>Обновляем тему "#theme#"</p>}}

{{if:url:<p>Качаем обновление с <a href="#url#">#url#</a></p>}}

{{if:dl_path:<p>Сохраняем файл обновления в <a href="/#dl_path##filename#">#doc_root##dl_path##filename#</a></p>}}

{{if:result:<p>#result#</p>}}

{{if:show_update_form:
<form action="/updater/theme/" method="post">
<input type="hidden" name="theme" value="#theme#">
<input type="submit" name="do_update" value="Обновить">
</form>
}}
