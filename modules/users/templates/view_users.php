<h1>������������������ ������������</h1>

{{if:show_admin_link:
<p>
<a href="/users/admin/">���������� ��������������</a>
</p>
}}

<hr>

{{if:result:<p>#result#</p>}}

{{if:content:<p>#content#</p>}}

<table summary="Users list table">
<tr>
<th style="padding: 0px 5px 0px 5px; vertical-align: top">ID</th>
<th style="padding: 0px 5px 0px 5px; vertical-align: top">login</th>
<th style="padding: 0px 5px 0px 5px; vertical-align: top">���</th>
<th style="padding: 0px 5px 0px 5px; vertical-align: top">email</th>
<th style="padding: 0px 5px 0px 5px; vertical-align: top">������</th>
</tr>
#users#
</table>
