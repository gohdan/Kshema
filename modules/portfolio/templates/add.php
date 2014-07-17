<h1>Добавление в портфолио</h1>

<p>
<a href="/index.php?module=portfolio&amp;action=admin">К администрированию портфолио</a><br>
<a href="/index.php?module=portfolio&amp;action=help#portfolio_add">Справка</a>
</p>

<p>#result#</p>

<p>#content#</p>

<form action="/index.php?module=portfolio&amp;action=add_portfolio" method="post" enctype="multipart/form-data">
<table summary="portfolio add table">
<tr><td>Название:</td><td><input type="text" name="name"></td></tr>
<tr><td>Дата <i>(Не меняйте формат!)</i>:</td><td><input type="text" name="date" size="10" align="right" value="#date#"></td></tr>
<tr><td>Категория:</td><td><select name="category">#categories_select#</select></td></tr>
<tr><td>Изображение-описание:</td><td><input type="file" name="image"></td></tr>
<tr><td>Короткое описание:</td></tr>
<tr><td colspan="2"><textarea style="width: 300px; height: 200px;" name="short_descr"></textarea></td></tr>
<tr><td>Описание:</td></tr>
<tr><td colspan="2"><textarea cols="50" rows="20" name="descr"></textarea></td></tr>
<tr><td>Полный текст:</td></tr>
<tr><td colspan="2"><textarea cols="50" rows="20" name="full_text"></textarea></td></tr>
<tr><td></td><td><input type="submit" name="do_add" value="Добавить"></td></tr>
</table>
</form>
