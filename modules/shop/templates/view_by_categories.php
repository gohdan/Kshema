<h1>#category_name#</h1>

<p>#result#</p>

<p>#content#</p>

{{if:show_admin_link:<p><a href="/shop/admin/">���������������� �������</a></p>}}

{{if:show_add_link:<p><a href="/shop/goods_add/category:#category_id#">�������� ����� � ���������</a></p>}}

{{if:subcategories:
<h2>������������</h2>

<p>
#subcategories#
<p>
}}

<p>��������: #pages# |<p>

{{if:show_multiple_add_form:<form action="/shop/cart_add_multiple/" method="post">}}


<table>
#goods_by_category#
</table>

{{if:show_multiple_add_form:<input type="submit" name="do_add" value="�������� � �������"></form>}}

<p>��������: #pages# |<p>
