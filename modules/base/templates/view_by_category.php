{{if:category_title:<h1>#category_title#</h1>}}


{{if:show_admin_link:
<p>
<a href="#inst_root#/#module_name#/categories_view/">� ������ ���������</a><br>
<a href="#inst_root#/#module_name#/help#view_by_category">�������</a>
</p>}}

{{if:show_link_on_main:<p><a href="#inst_root#/#module_name#/">�� ������� ��������</a></p>}}

{{if:category_id:<p><a href="#inst_root#/#module_name#/add/#category_id#/">�������� � ���������</a></p>}}

{{if:parent_link:<p><a href="#inst_root#/#module_name##action#/#parent_link#/">�� ������� ����</a></p>}}

{{if:parents:������������������ ���������: #parents#}}

{{if:subcategories:<h2>������������</h2>}}

#subcategories#

{{if:elements:<h2>����������</h2>}}
<table summary="elements">
#elements#
</table>

{{if:category_pages:<p>#category_pages#</p>}}

{{if:result:#result#}}

