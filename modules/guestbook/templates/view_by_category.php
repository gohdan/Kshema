{{if:category_title:<h1>#category_title#</h1>}}

{{if:show_admin_link:
<p>
<a href="/guestbook/categories_view/">� ������ ���������</a><br>
<a href="/guestbook/help#view_by_category">�������</a>
</p>}}

<a href="/guestbook/add/#category_id#/">�������� ���������</a><br>

{{if:show_link_on_main:<p><a href="/guestbook/">� ������ �������� �����</a></p>}}

{{if:guestbook:<h2>���������</h2>}}
<table summary="guestbook">
#messages#
</table>

{{if:pages:<p>#pages#</p>}}

{{if:result:#result#}}

