<h1>�������������� ������ ������������</h1>

<p><a href="/users/help#users_profile_edit">�������</a></p>

<p><a href="/users/profile_view/">������� � �������� ����� ������� ������</a></p>

{{if:result:<p>#result#</p>}}

{{if:content:<p>#content#</p>}}

<form name="" action="/users/profile_edit/" method="post">

<table class="tbl_form">
<tr>
        <td>�������:</td><td><input  style="width:260" size="45" type="text" name="sur_name" value="#sur_name#"></td>
</tr>
<tr>
        <td>���</td><td><input  style="width:260" size="45" type="text" name="first_name" value="#first_name#"></td>
</tr>
<tr>
        <td>��������:</td><td><input  style="width:260" size="45" type="text" name="second_name" value="#second_name#"></td>
</tr>
<tr>

        <td>������:</td><td><select name="country"><option value="������">������</option></select></td>
</tr>
<tr>
        <td>������:</td><td><input type="text" size="6" width="50" name="post_code" value="#post_code#"></td>
</tr>
<tr>
        <td>�������:</td><td><input type="text" style="width:260" size="100"  name="area" value="#area#"></td>
</tr>
<tr>
        <td>�����:</td><td><input type="text" style="width:260" size="100"  name="city" value="#city#"></td>

</tr>
<tr>
        <td>�����/���/��������:</td><td><input type="text" style="width:260" size="100"  name="address" value="#address#"></td>
</tr>
</table><br>
<input type="submit" name="do_change" value="��������� ���������" class="button">
</form>
