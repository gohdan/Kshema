<h1>Основы - руководство разработчика</h1>

<p><a href="/index.php?module=base&amp;action=admin">Обратно к администрированию</a></p>

<ul>
<li><a href="#module_creation">Создание модуля</a></li>
<li>
<a href="#screen_output">Вывод на экран</a>
<ul>
<li><a href="#output_itself">СОбственно вывод</a></li>
<li><a href="#template_logic">Использование условий в шаблонах</a></li>
</ul>
</li>
<li>
<a href="#api">API</a>
<ul>
<li><a href="#base">base</a>
<ul>
<li><a href="#functions_debug">debug</a></li>
<li><a href="#functions_dump">dump</a></li>
<li><a href="#functions_base_get_month_name">base_get_month_name</a></li>
<li><a href="#functions_base_get_month_num">base_get_month_num</a></li>
</ul>
</li>
<li><a href="#users">users</a>
<ul>
<li><a href="#functions_users_current_id">users_current_id</a></li>
<li><a href="#functions_users_get_info">users_get_info</a></li>
</ul>
</li>
</ul>
</li>
</ul>

<h2><a name="module_creation">Создание модуля</a></h2>

<ol>
<li>Зарегистрировать модуль в списке модулей функции module_exists (/modules/modules/index.php)</li>
<li>Создать каталог для модуля в /modules/</li>
<li>В этом каталоге создать файл index.php</li>
<li>Если модуль выводит контент, в index.php обязательно должна присутствовать функция {название модуля}_default_action; как она оформляется, можно посмотреть в других (например, в модуле news)</li>
<li>Если нужно, создать каталог templates и класть туда шаблоны для вывода содержимого функциями. Шаблонизатор сначала ищет шаблоны в теме оформления в соответствующих каталогах (/themes/{название темы}/templates/{название модуля}/{название шаблона}.php; если не находит, ищет этот шаблон в /modules/{название модуля}/templates/{название шаблона}.php; если не находит и там, берёт дефолтный шаблон из модуля base.</li>
<li>Если модуль работает со своими таблицами в базе данных, нужно создать соответствующие инструкции для их создания, обновления и удаления; можно просто скопировать файл db.php из другого модуля (например, news). Для единообразия у таблиц должен быть префикс ksh_{название модуля}_</li>
</ol>

<h2><a name="screen_output">Вывод на экран</a></h2>

<h3><a name="output_itself">Собственно вывод</a></h3>

<p>
$content = gen_content(название_модуля, название_шаблона, функция);
</p>

<p>
Пример:
</p>
<pre>
function hello()
{
    $content['content'] = "ПРИВЕТ";
    return $content;
}
$content = gen_content('registration', 'hello', hello());
</pre>

<p>
Этот код, будучи подгружен движком, встроит твой шаблон с заменёнными переменными в общий шаблон страницы.
</p>

<h3><a name="template_logic">Использование условий в шаблонах</a></h3>

<p>
Пример:
</p>
<pre>
{{if:price:Цена: #price#}}
</pre>

<p>
Если переменная $content['price'] установлена и не равна "", пользователю 
будет выведено:
</p>
<pre>
Цена: #price#
</pre>
<p>
Естественно, #price# будет заменено на $content['price'].
</p>

<p>
Иначе не будет выведено ничего.
</p>

<p>Символы, которые можно выводить через условие: a-zA-Zа-яА-Я0-9/ _&lt;&gt;=#:".)(

<h2><a name="api">API</a></h2>

<h3><a name="base">base</a></h3>

<h4><a name="functions_debug">debug</a></h4>

<p>Если дебаг разрешён в конфиге, выводит аргумент на экран.</p>

<p>debug (строка $string) выведет $string на экран (фактически - обёртка для echo).
Чтобы задействовать дебаг, нужно в /themes/название_темы/config.php присвоить $config['base']['debug'] значение "on". 
Даже будучи включенным, дебаг показывается только администратору или пользователю с ID, прописанным в $config['base']['debug_user'] (по умолчанию - 1).
</p>

<h4><a name="functions_dump">dump</a></h4>

<p>Если дебаг разрешён в конфиге, выводит print_r аргумента на экран.</p>

<h4><a name="functions_base_get_month_name">base_get_month_name</a></h4>

<p>Возвращает название месяца по его порядковому номеру.</p>

<h4><a name="functions_base_get_month_num">base_get_month_num</a></h4>

<p>Возвращает порядковый номер месяца по его сокращённому английскому названию.</p>


<h3><a name="users">users</a></h3>

<h4><a name="functions_users_current_id">users_current_id</a></h4>

<p>users_current_id() - возвращает ID текущего пользователя</p>

<h4><a name="functions_users_get_info">users_get_info</a></h4>

<p>users_get_info(целое $user_id) - по ID возвращает полную информацию о пользователе в виде ассоциативного массива</p>

