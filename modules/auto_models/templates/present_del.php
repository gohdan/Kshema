<h1>�������� ���������� � �������</h1>

<p><a href="/auto_models/present_view/">� ������</a></p>

{{if:result:<p>#result#</p>}}

{{if:show_del_form:
<p>�� ������������� ������ ������� ���������� � ������� <b>#title#</b>?</p>


<form action="/auto_models/present_del/#id#/" method="post">

<input type="hidden" name="id" value="#id#">
<input type="submit" name="do_not_del" value="�� �������">
<input type="submit" name="do_del" value="�������">
</form>
}}
