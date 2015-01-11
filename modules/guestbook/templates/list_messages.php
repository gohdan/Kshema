<tr>
<td style="padding: 10px 0px 0px 0px">
<b>#title#</b><br>
#datetime#<br>
{{if:name:Имя: #name#<br>}}
{{if:contact:Способ связи: #contact#<br>}}
</td>
</tr>
<tr>
<td style="padding: 0px 0px 0px 0px">
#text#
</td>
</tr>
{{if:show_admin_link:
<tr>
<td>
<a href="/guestbook/edit/#id#/">Редактировать</a> 
<a href="/guestbook/del/#id#/">Удалить</a> 
</td>
</tr>
}}
</tr>
