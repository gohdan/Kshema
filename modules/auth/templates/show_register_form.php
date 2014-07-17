
<p>
#content#
</p>

{{if:if_show_register_form:
<form class="auth_register" action="/index.php?module=auth&action=register" method="post">

	<table class="tbl_form">
		<tr><th colspan="2">Р Е Г И С Т Р А Ц И Я</th></tr>
		<tr>
			<td width="160">Имя <span class="comment">(ник)</span></td>
			<td><input type="text" name="name" value=""></td>

		</tr>
		<tr>
			<td width="160">E-mail <span class="comment">(используется в дальнейшем как логин)</span></td>
			<td><input type="text" name="login" value=""></td>
		</tr>
		<tr>
			<td width="160">Пароль <span class="comment">(не меньше 6 символов)</span></td>

			<td><input type="password" name="password1" ></td>
		</tr>
		<tr>
			<td width="160">Повтор пароля</td>
			<td><input type="password" name="password2"></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" class="button" name="do_register" value="Зарегистрироваться"></td>

		</tr>
	</table>
</form>
}}

