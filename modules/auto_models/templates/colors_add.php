<h1>���������� ������ #model_title#</h1>

<p>
<a href="/index.php?module=auto_models&action=colors_view&model=#model#">� ��������� ������ ���� ������</a>
</p>

<p>#result#</p>

<p>#content#</p>

{{if:if_show_add_form:
<form action="/index.php?module=auto_models&action=colors_add&model=#model#" method="post" enctype="multipart/form-data">
<input type="hidden" name="model" value="#model#">
��������: <input type="text" name="title"><br>
�����������: <input type="file" name="image"><br>
���: <input type="text" name="code"><br>
<input type="submit" name="do_add" value="��������">
</form>
}}
