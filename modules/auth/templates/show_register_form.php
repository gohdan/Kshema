<h1>Регистрация</h1>

{{if:if_show_register_form:
<form class="auth_register" action="/auth/register/" method="post">
<input type="text" name="email" placeholder="E-mail">
<input type="submit" class="button" name="do_register" value="Зарегистрироваться"></td>
</form>
}}

{{if:if_deny:<p>Извините, регистрация закрыта</p>}}
