<h1>#title#</h1>

<p>
{{if:id:
<a href="/index.php?module=auto_models&action=characteristics_view&model=#id#">����������� ��������������</a><br>
<a href="/index.php?module=auto_models&action=prices_view&model=#id#">������������ � ����</a><br>
<a href="/index.php?module=auto_models&action=equipment_view&model=#id#">�������������� ������������</a><br>
<a href="/index.php?module=auto_models&action=images_view&model=#id#">�����������</a><br>
<a href="/index.php?module=auto_models&action=videos_view&model=#id#">�����������</a><br>
<a href="/index.php?module=auto_models&action=colors_view&model=#id#">�����</a><br>
}}
{{if:link:<a href="#link#">������</a><br>}}
</p>

{{if:if_show_edit_link:
<p><a href="/index.php?module=auto_models&action=edit&model=#id#">�������������</a></p>
}}

<p>#content#</p>

#full_text#
