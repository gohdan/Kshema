<tr>
<td>
{{if:image:<a href="/shop/view_good/good:#id#"><img src="#image#" style="float: left"></a>}}
</td>

<td style="vertical-align: top; padding: 20px">
<div style="display: inline; float: left; margin-right: 20px">
<b><a href="/shop/view_good/good:#id#">#name#</a></b><br>
<b><a href="/shop/view_by_authors/authors:#author#">#author_name#</a></b><br>
<b><a href="/shop/view_by_categories/categories:#category#">#category_name#</a></b><br>
</div>
{{if:show_request_link:<div style="display: inline">������ ������ � ������� ���.<br>�� ������ <a href="/shop/view_good/good:#id#">�������� ������</a></div>}}
</td>

{{if:show_edit_link:<td style="padding: 0px 3px 0px 3px"><a href="/shop/goods_edit/#id#/">�������������</a></td>}}
{{if:show_del_link:<td style="padding: 0px 3px 0px 3px"><a href="/shop/goods_del/#id#/">�������</a></td>}}

</tr>

<tr>
<td colspan="4">
{{if:new_qty:<p><input type="checkbox" name="good_#id#" value="#id#"><b>#new_price# ���.</b></p>}}
<p>#presence#</p>
</td>
</tr>

<tr>
<td colspan="4"><hr color="#DAEDFF"></td>
</tr>
