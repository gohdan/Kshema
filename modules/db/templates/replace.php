<h1>����� � ������ �� ��</h1>

<form action="/index.php?module=db&action=replace" method="post">
�������: <input type="text" name="search_table" value="#search_table#"><br>
����: <input type="text" name="search_field" value="#search_field#"><br>
��� ����: <input type="text" name="search_string" value="#search_string#"><br>
<input type="checkbox" name="if_replace"#if_replace#> �������� ��: <input type="text" name="replace_string" value="#replace_string#"><br>
<input type="submit" name="do_replace" value="�������!">
</form>

<p>#result#</p>