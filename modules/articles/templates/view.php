{{if:show_user_articles_link:<p><a href="#inst_root#/articles/view_by_user/">��� ������</a></p>}}

{{if:title:<h1>#title#</h1>}}

{{if:show_admin_link:
<p>
<a href="/articles/edit/#id#">�������������</a><br>
<a href="#inst_root#/articles/admin/">���� ����������������� ������</a><br>
<a href="#inst_root#/articles/help#view">�������</a>
</p>
}}

{{if:content:<p>#content#</p>}}

{{if:date:<p>#date#</p>}}

{{if:full_text:#full_text#}}

{{if:category:<p><a href="#inst_root##module##action#/#category#/">������� � ���������</a></p>}}



{{if:resemble_elements:
<h2>������� ������</h2>
<table>
#resemble_elements#
</table>}}

