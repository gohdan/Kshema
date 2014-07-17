<tr>
<td>{{if:show_checkbox:<input type="checkbox" name="bill_#id#"> }}{{if:show_checked_checkbox:<input type="checkbox" name="bill_#id#" checked> }}#id#</td>
<td><a href="#inst_root#/#module_name#/view/#name#.html">#title# (#name#)</a></td>
{{if:show_admin_link:
<td><a href="#site_url##inst_root#/#module_name#/edit/#id#/">Редактировать</a></td>
<td><a href="#site_url##inst_root#/#module_name#/del/#id#/">Удалить</a></td>
}}
</tr>
