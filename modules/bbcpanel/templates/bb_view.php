<h1>�������� ����� ���������� #title#</h1>

{{if:content:<p>#content#</p>}}

<p>
<a href="/bbcpanel/view_by_category/#category#/">������� � ���������</a>
</p>

{{if:show_admin_link:
<p>
<a href="/bbcpanel/admin/">���� ����������������� ����� ����������</a><br>
<a href="/bbcpanel/help#bb_add">�������</a>
</p>
}}

<p>
ID: #id#<br>
��������� ��������: #name#<br>
�������� ��� ������ ������������: #title#<br>
��������: #subjects#<br>
���������: #category_title#<br>
URL: {{if:url:<a href="#url#">#url#</a>}}<br>
�������: <ul>#sections#</ul><br>
���������� �� ��������: #bills_per_page#<br>
����� ��������� ����������: #bill_view_mode#<br>
���� ����������: #theme#
</p>
