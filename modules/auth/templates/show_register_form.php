
<p>
#content#
</p>

{{if:if_show_register_form:
<form class="auth_register" action="/index.php?module=auth&action=register" method="post">

	<table class="tbl_form">
		<tr><th colspan="2">� � � � � � � � � � �</th></tr>
		<tr>
			<td width="160">��� <span class="comment">(���)</span></td>
			<td><input type="text" name="name" value=""></td>

		</tr>
		<tr>
			<td width="160">E-mail <span class="comment">(������������ � ���������� ��� �����)</span></td>
			<td><input type="text" name="login" value=""></td>
		</tr>
		<tr>
			<td width="160">������ <span class="comment">(�� ������ 6 ��������)</span></td>

			<td><input type="password" name="password1" ></td>
		</tr>
		<tr>
			<td width="160">������ ������</td>
			<td><input type="password" name="password2"></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" class="button" name="do_register" value="������������������"></td>

		</tr>
	</table>
</form>
}}

