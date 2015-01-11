<h1>Поиск и замена по БД</h1>

<form action="/index.php?module=db&action=replace" method="post">
Таблица: <input type="text" name="search_table" value="#search_table#"><br>
Поле: <input type="text" name="search_field" value="#search_field#"><br>
Что ищем: <input type="text" name="search_string" value="#search_string#"><br>
<input type="checkbox" name="if_replace"#if_replace#> Заменяем на: <input type="text" name="replace_string" value="#replace_string#"><br>
<input type="submit" name="do_replace" value="Поехали!">
</form>

<p>#result#</p>