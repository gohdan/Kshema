<h1>�������������� �����������</h1>

<p>
<a href="/index.php?module=auto_models&action=videos_view&model=#model#">� ��������� ������������ ���� ������</a>
</p>

<p>#result#</p>

<p>#content#</p>

{{if:if_show_edit_form:
<form action="/index.php?module=auto_models&action=videos_edit&videos=#id#" method="post">
<input type="hidden" name="id" value="#id#">
��������: <input type="text" name="title" value="#title#"><br>
��� ������:<br>
<textarea name="video" style="width: 500px; height: 200px">#video#</textarea><br>
��������:<br>
<textarea name="descr" rows="30" cols="40">#descr#</textarea><br>
<input type="submit" name="do_save" value="���������">
</form>
}}
