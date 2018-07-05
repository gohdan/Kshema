<h1>Сброс пароля</h1>

{{if:empty_email:
<p>Пожалуйста, введите email.</p>
}}

{{if:no_email:
<p>Пользователь с таким email не зарегистрирован.</p>
}}

{{if:password_changed:
<p>Пароль изменён, письмо с новым паролем выслано по указанному email.</p>
}}

{{if:if_show_form:
<form class="auth_login" action="/auth/reset_password/" method="post">
<input type="text" name="email" value="#email#" placeholder="Email"><br>
<input type="submit" name="do_reset" value="Сбросить пароль">
</form>
}}

{{if:if_show_register_link:
<p><a href="/auth/show_register_form">Зарегистрироваться</a></p>
}}
