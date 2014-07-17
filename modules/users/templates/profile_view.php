{{if:name:<h1>#name#</h1>}}

{{if:show_admin_link:<p><a href="#inst_root#/base/admin/">Администрировать сайт</a></p>}}

{{if:show_logout_link:<p><a href="#inst_root#/auth/logout">Выйти из системы</a></p>}}
{{if:show_change_password_link:<p><a href="#inst_root#/auth/change_password">Сменить пароль</a></p>}}



<h2>Личные данные</h2>

{{if:id:ID: #id#<br>}}
{{if:login:Логин: #login#<br>}}
{{if:name:Имя: #name#<br>}}
{{if:group: Группа: #group#<br>}}
{{if:first_name: Имя: #first_name#<br>}}
{{if:second_name: Отчество: #second_name#<br>}}
{{if:sur_name: Фамилия: #sur_name#<br>}}
{{if:country: Страна: #country#<br>}}
{{if:post_code: Почтовый индекс: #post_code#<br>}}
{{if:area: Область: #area#<br>}}
{{if:city: Город: #city#<br>}}
{{if:address: Адрес: #address#<br>}}
{{if:last_login_date:Дата последнего входа: #last_login_date#<br>}}
{{if:last_login_time:Время последнего входа: #last_login_time#<br>}}
{{if:last_login_date_never:Дата последнего входа: никогда<br>}}
{{if:show_profile_edit_link:<p><a href="#inst_root#/users/profile_edit/">Редактировать личные данные</a></p>}}

{{if:modules:<h2>Модули</h2>
#modules#}}

