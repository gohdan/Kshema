<h1>���������� ������������ #model_title#</h1>

<p>
<a href="/index.php?module=auto_models&action=videos_view&model=#model#">� ��������� ������������ ���� ������</a>
</p>

<p>#result#</p>

<p>#content#</p>

{{if:if_show_add_form:
<form action="/index.php?module=auto_models&action=videos_add&model=#model#" method="post">
<input type="hidden" name="model" value="#model#">
��������: <input type="text" name="title"><br>
��� ������:<br>
<textarea name="video" style="width: 500px; height: 200px"></textarea><br>
��������:<br>
<textarea name="descr" rows="30" cols="40"></textarea><br>
<input type="submit" name="do_add" value="��������">
</form>
}}
