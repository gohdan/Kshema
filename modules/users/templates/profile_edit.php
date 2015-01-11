<h1>Редактирование данных пользователя</h1>

<p><a href="/users/help#users_profile_edit">Справка</a></p>

<p><a href="/users/profile_view/">Обратно в просмотр Ваших учётных данных</a></p>

{{if:result:<p>#result#</p>}}

{{if:content:<p>#content#</p>}}

<form name="" action="/users/profile_edit/" method="post">

<table class="tbl_form">
<tr>
        <td>Фамилия:</td><td><input  style="width:260" size="45" type="text" name="sur_name" value="#sur_name#"></td>
</tr>
<tr>
        <td>Имя</td><td><input  style="width:260" size="45" type="text" name="first_name" value="#first_name#"></td>
</tr>
<tr>
        <td>Отчество:</td><td><input  style="width:260" size="45" type="text" name="second_name" value="#second_name#"></td>
</tr>
<tr>

        <td>Страна:</td><td><select name="country"><option value="Россия">Россия</option></select></td>
</tr>
<tr>
        <td>Индекс:</td><td><input type="text" size="6" width="50" name="post_code" value="#post_code#"></td>
</tr>
<tr>
        <td>Область:</td><td><input type="text" style="width:260" size="100"  name="area" value="#area#"></td>
</tr>
<tr>
        <td>Город:</td><td><input type="text" style="width:260" size="100"  name="city" value="#city#"></td>

</tr>
<tr>
        <td>Улица/дом/квартира:</td><td><input type="text" style="width:260" size="100"  name="address" value="#address#"></td>
</tr>
</table><br>
<input type="submit" name="do_change" value="Сохранить изменения" class="button">
</form>
