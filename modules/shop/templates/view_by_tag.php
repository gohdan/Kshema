<h1>#tag#</h1>

<p>#result#</p>

<p>#content#</p>

{{if:show_admin_link:<p><a href="/shop/admin/">���������������� �������</a></p>}}

{{if:show_multiple_add_form:<form action="/shop/cart_add_multiple/" method="post">}}

<p>��������: #pages# |<p>


<table>
#goods_by_tag#
</table>

{{if:show_multiple_add_form:<input type="submit" name="do_add" value="�������� � �������"></form>}}

<p>��������: #pages# |<p>
