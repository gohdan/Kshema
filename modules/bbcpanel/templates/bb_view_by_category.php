<h1>#category_title#</h1>

{{if:show_admin_link:
<p>
<a href="/bbcpanel/admin/">���� �����������������</a>
</p>
}}

<p><a href="/users/profile_view/">��� �������</a></p>

{{if:show_add_link:
<p>
<a href="/bbcpanel/bb_add/">�������� ��������</a>
</p>
}}

{{if:result:<p>#result#</p>}}

{{if:admin_link:<p>#admin_link#</p>}}


{{if:content:<p>#content#</p>}}

<form action="/bbcpanel/bbs_view_all/" method="post">

<table class="bbcpanel_bbs_list" summary="billboards">
<tr>
<th></th>
<th></th>
<th style="padding: 0px 3px 3px 3px">
ID
</th>
<th style="padding: 0px 3px 0px 3px">
��������
</th>
<th style="padding: 0px 3px 0px 3px">
URL
</th>
<th style="padding: 0px 3px 0px 3px">
��������
</th>
</tr>
#bbs#
</table>

<p>
� �����������: <select name="action">
<option value="updater|update_all">�������� ����������� ���</option>
<option value="bills|update_tables">�������� �� ����������</option>
<option value="articles|update_tables">�������� �� ������</option>
</select>
<input type="submit" name="do_action" value="�������">
</form>
