<h1>�������� �����������</h1>

<p>#content#</p>

<p>
<a href="/index.php?module=auto_models&action=videos_view&model=#model#">� ��������� ������������ ���� ������</a>
</p>

{{if:if_show_del_form:
<form action="/index.php?module=auto_models&action=videos_view&model=#model#" method="post">
<input type="hidden" name="id" value="#id#">
�� ������������� ������ ������� <b>#title#</b>?<br>
<input type="submit" name="do_not_del" value="���">
<input type="submit" name="do_del" value="��">
</form>
}}
