{{if:category_title:<h1>#category_title#</h1>}}


{{if:show_admin_link:
<p>
<a href="#inst_root#/#module_name#/categories_view/">К списку категорий</a><br>
<a href="#inst_root#/#module_name#/help#view_by_category">Справка</a>
</p>}}

{{if:show_link_on_main:<p><a href="#inst_root#/#module_name#/">На главную страницу</a></p>}}

{{if:category_id:<p><a href="#inst_root#/#module_name#/add/#category_id#/">Добавить в категорию</a></p>}}

{{if:parent_link:<p><a href="#inst_root#/#module_name##action#/#parent_link#/">На уровень выше</a></p>}}

{{if:parents:Последовательность категорий: #parents#}}

{{if:subcategories:<h2>Подкатегории</h2>}}

#subcategories#

{{if:elements:<h2>Содержимое</h2>}}
<table summary="elements">
#elements#
</table>

{{if:category_pages:<p>#category_pages#</p>}}

{{if:result:<p>#result#</p>}}

