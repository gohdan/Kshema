<h1>#heading#</h1>

<p>
<a href="/users/profile_view/">��� �������</a>
{{if:show_admin_link:<br><a href="/updater/admin/">������� � ���� �����������������</a>}}
</p>

{{if:theme:<p>��������� ���� "#theme#"</p>}}

{{if:url:<p>������ ���������� � <a href="#url#">#url#</a></p>}}

{{if:dl_path:<p>��������� ���� ���������� � <a href="/#dl_path##filename#">#doc_root##dl_path##filename#</a></p>}}

{{if:result:<p>#result#</p>}}

{{if:show_update_form:
<form action="/updater/theme/" method="post">
<input type="hidden" name="theme" value="#theme#">
<input type="submit" name="do_update" value="��������">
</form>
}}
