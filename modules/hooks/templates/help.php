<h1>Привязки динамического контента - справка</h1>

<p><a href="/index.php?module=hooks&amp;action=admin">Обратно к администрированию</a></p>

<ul>
<li><a href="#common">Общие сведения</a></li>
<li><a href="#categories">Категории</a>
<ul>
<li><a href="#categories_common">Общие сведения</a></li>
<li><a href="#categories_add">Добавление</a></li>
<li><a href="#categories_edit">Редактирование</a></li>
<li><a href="#categories_del">Удаление</a></li>
</ul>
</li>
<li><a href="#hooks">Привязки</a>
<ul>
<li><a href="#hooks_common">Общие сведения</a></li>
<li><a href="#hooks_add">Добавление</a></li>
<li><a href="#hooks_edit">Редактирование</a></li>
<li><a href="#hooks_del">Удаление</a></li>
<li><a href="#hooks_view_by_category">Просмотр по категориям</a></li>
</ul>
</li>
<li><a href="#db">База данных</a>
<ul>
<li><a href="#db_common">Общие сведения</a></li>
<li><a href="#db_tables_create">Создание таблиц</a></li>
<li><a href="#db_tables_drop">Удаление таблиц</a></li>
<li><a href="#db_tables_update">Обновление таблиц</a></li>
</ul>
</li>
</ul>

<h2><a name="common">Общие сведения</a></h2>

<p>Модуль привязок динамического контента позволяет организовывать привязки динамического контента.</p>

<h2><a name="categories">Категории</a></h2>

<h3><a name="categories_common">Общие сведения</a></h3>

<p><a href="/index.php?module=base&amp;action=help#categories_common">Основной раздел справки</a></p>

<h3><a name="categories_add">Добавление</a></h3>

<p><a href="/index.php?module=base&amp;action=help#categories_add">Основной раздел справки</a></p>

<h3><a name="categories_edit">Редактирование</a></h3>

<p><a href="/index.php?module=base&amp;action=help#categories_edit">Основной раздел справки</a></p>

<h3><a name="categories_del">Удаление</a></h3>

<p><a href="/index.php?module=base&amp;action=help#categories_del">Основной раздел справки</a></p>

<h2><a name="hooks">Привязки</a></h2>

<h3><a name="hooks_common">Общие сведения</a></h3>

<h3><a name="hooks_add">Добавление</a></h3>

<ul>
<li>Название - отображаемое название привязки.</li>
<li>Категория - каждая привязка принадлежит какой-нибудь категории.</li>
<li>Привязываемый модуль - системное название модуля, контент из которого привязываем.</li>
<li>Тип содержимого - категория или элемент.</li>
<li>ID содержимого - ID категории или элемента.</li>
</ul>

<h3><a name="hooks_edit">Редактирование</a></h3>

<ul>
<li>Название - отображаемое название привязки.</li>
<li>Категория - каждая привязка принадлежит какой-нибудь категории.</li>
<li>Привязываемый модуль - системное название модуля, контент из которого привязываем.</li>
<li>Тип содержимого - категория или элемент.</li>
<li>ID содержимого - ID категории или элемента.</li>
</ul>

<h3><a name="hooks_del">Удаление</a></h3>

<h3><a name="hooks_view_by_category">Просмотр по категориям</a></h3>

<p><a href="/index.php?module=base&amp;action=help#dataobject_view_by_category">Основной раздел справки</a></p>

<h2><a name="db">База данных</a></h2>

<h3><a name="db_common">Общие сведения</a></h3>

<p>В базе данных привязки хранятся в следующих таблицах:</p>

<ul>
<li>ksh_hooks_categories - категории привязок;</li>
<li>ksh_hooks - сами привязки.</li>
</ul>

<h3><a name="db_tables_create">Создание таблиц</a></h3>

<p>При исполнении этого экшена создаются таблицы в базе данных.</p>

<h3><a name="db_tables_drop">Удаление таблиц</a></h3>

<p>При исполнении этого экшена даётся возможность удалить таблицы из базы данных - можно выбрать, какие.</p>

<h3><a name="db_tables_update">Обновление таблиц</a></h3>

<p>Этот экшен занимается обновлением таблиц базы данных, сохранившихся с более старых версий модуля.</p>
