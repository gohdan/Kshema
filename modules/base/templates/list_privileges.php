<input type="hidden" name="entries[]" value="#uid#">
<input type="hidden" name="read_#uid#" value="0">
<input type="hidden" name="write_#uid#" value="0">

<tr>
<td><input type="text" name="action_#uid#" value="#action#"></td>
<td><select name="type_#uid#">
<option value="group"{{if:group_selected: selected}}>группа</option>
<option value="user"{{if:user_selected: selected}}>пользователь</option>
</select></td>
<td><input type="text" name="id_#uid#" value="#id#" size="3"></td>
<td><input type="checkbox" name="read_#uid#" value="1"{{if:read_checked: checked}}></td>
<td><input type="checkbox" name="write_#uid#" value="1"{{if:write_checked: checked}}></td>

</tr>

