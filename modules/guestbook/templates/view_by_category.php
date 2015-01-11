{{if:category_title:<h1>#category_title#</h1>}}

{{if:show_admin_link:
<p>
<a href="/guestbook/categories_view/">К списку категорий</a><br>
<a href="/guestbook/help#view_by_category">Справка</a>
</p>}}

<a href="/guestbook/add/#category_id#/">Добавить сообщение</a><br>

{{if:show_link_on_main:<p><a href="/guestbook/">В начало гостевой книги</a></p>}}

{{if:guestbook:<h2>Сообщения</h2>}}
<table summary="guestbook">
#messages#
</table>

{{if:pages:<p>#pages#</p>}}

{{if:result:#result#}}

