<tr>
<td>
{{if:image:<a href="/shop/view_good/good:#id#"><img src="#image#" style="float: left"></a>}}
</td>

<td style="vertical-align: top; padding: 20px">
<div style="display: inline; float: left; margin-right: 20px">
<b><a href="/shop/view_good/good:#id#">#name#</a></b><br>
<b><a href="/shop/view_by_authors/authors:#author#">#author_name#</a></b><br>

{{if:show_edit_link:<a href="/shop/goods_edit/goods:#id#">�������������</a><br>}}
{{if:show_del_link:<a href="/shop/goods_del/goods:#id#">�������</a><br>}}
</div>
{{if:show_request_link:<div style="display: inline">������ ������ � ������� ���.<br>�� ������ <a href="/shop/view_good/good:#id#">�������� ������</a></div>}}
</td>

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
