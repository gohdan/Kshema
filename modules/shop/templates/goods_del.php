<h1>Удаление товара</h1>

<p><a href="/index.php?module=shop&action=goods_view_all">К просмотру товаров</a></p>

<hr>

<p>Вы действительно хотите удалить товар <b>#name#</b>?</b>

<form action="/index.php?module=shop&action=goods_view_all" method="post">
<input type="hidden" name="id" value="#id#">
<input type="submit" name="do_not_del" value="Нет">
<input type="submit" name="do_del" value="Да">
</form>