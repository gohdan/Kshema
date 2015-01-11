{{if:if_show_admin_link:
<p>
<a href="/index.php?module=portfolio&amp;action=edit&amp;portfolio=#id#">Редактировать</a><br>
<a href="/index.php?module=portfolio&amp;action=del&amp;portfolio=#id#">Удалить</a>
</p>
}}

{{if:descr_image:<p><img src="#descr_image#"></p>}}

{{if:date:<p>#date#</p>}}

#full_text#

<p><a href="/index.php?module=portfolio&amp;action=view_by_category&amp;category=#category_id#">Все портфолио из категории "#category#"</a></p>
