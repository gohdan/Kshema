<tr>
<td style="padding: 0px 3px 3px 3px">
#id#
</td>
<td style="padding: 0px 3px 0px 3px">
#position#
</td>
<td style="padding: 0px 3px 0px 3px">
<a href="#url#"{{if:if_new_window: target="#new_window_name#"}}>#title#</a>
</td>
<td>
{{if:submenu_id:<a href="/index.php?module=menu&amp;action=view_by_category&amp;category=#submenu_id#">#submenu_title#</a>}}
</td>
{{if:show_admin_link:
<td style="padding: 0px 3px 0px 3px">
<a href="/index.php?module=menu&amp;action=edit&amp;page=#id#">Редактировать</a> 
<a href="/index.php?module=menu&amp;action=del&amp;page=#id#">Удалить</a> 
</td>
}}
</tr>
