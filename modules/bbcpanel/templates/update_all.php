<h1>���������� ������������ ����</h1>

{{if:id:<a href="/bbcpanel/bb_edit/#id#/">������������� �����</a><br>}}

<p><a href="/bbcpanel/bbs_view_all">������ �����</a></p>

{{if:show_bb_select_form:
<form action="/bbcpanel/update_all/" method="post">
<select name="bb">#bbs_select#</select>
<input type="submit" name="do_select_bb" value="�������">
</form>
}}

{{if:show_update_form:
<form action="/bbcpanel/update_all/" method="post">
<input type="hidden" name="bb" value="#id#">
<input type="submit" name="do_update" value="��������">
</form>
}}

{{if:result:#result#}}
