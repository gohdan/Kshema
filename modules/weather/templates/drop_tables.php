<h1>����������� ������ ���� ������ ��������� ���������</h1>

{{if:content:<p>#content#<p>}}

{{if:result:<p>#result#</p>}}

<p>
<a href="/weather/admin/">��������� � ���� �����������������</a><br>
</p>


<p>
���������� �������:
</p>
<form action="/weather/drop_tables/" method="post">
<input type="checkbox" name="drop_categories_table" value="ksh_weather_categories">��������� ����������<br>
<input type="checkbox" name="drop_weather_table" value="ksh_weather">���������<br>
<input type="checkbox" name="drop_privileges_table" value="ksh_weather_privileges">����������<br>
<input type="submit" name="do_drop" value="����������">
</form>
