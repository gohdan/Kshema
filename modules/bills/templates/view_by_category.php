{{if:title:<h1>#category_title#</h1>}}

{{if:show_admin_link:
<p>
<a href="/bills/categories_view/">� ������ ���������</a><br>
<a href="/bills/help#view_by_category">�������</a>
</p>}}

{{if:show_link_on_main:<p><a href="/#module_name#/">�� ������� ��������</a></p>}}

{{if:category_id:<p><a href="/bills/add/#category_id#/">�������� ����������</a></p>}}

{{if:parent_link:<p><a href="#module_name##action#/#parent_link#/">�� ������� ����</a></p>}}

{{if:parents:������������������ ���������: #parents#}}

{{if:subcategories:<h2>���������</h2>}}

#subcategories#

{{if:bills:<h2>����������</h2>}}
<table summary="bills">
#elements#
</table>

{{if:category_pages:<p>#category_pages#</p>}}

{{if:result:#result#}}

