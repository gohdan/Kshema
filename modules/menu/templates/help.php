<h1>Меню - справка</h1>

<p><a href="/index.php?module=menu&amp;action=admin">Обратно к администрированию</a></p>

<ul>
<li><a href="#common">Общие сведения</a></li>
<li><a href="#categories">Списки меню</a>
<ul>
<li><a href="#categories_common">Общие сведения</a></li>
<li><a href="#categories_add">Добавление</a></li>
<li><a href="#categories_edit">Редактирование</a></li>
<li><a href="#categories_del">Удаление</a></li>
</ul>
</li>
<li><a href="#elements">Элементы меню</a>
<ul>
<li><a href="#elements_common">Общие сведения</a></li>
<li><a href="#elements_add">Добавление</a></li>
<li><a href="#elements_edit">Редактирование</a></li>
<li><a href="#elements_del">Удаление</a></li>
<li><a href="#elements_view_by_category">Просмотр по категориям</a></li>
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

<p>Модуль меню позволяет создавать списки меню.</p>

<h2><a name="categories">Списки меню</a></h2>

<h3><a name="categories_common">Общие сведения</a></h3>

<p><a href="/index.php?module=base&amp;action=help#categories_common">Основной раздел справки</a></p>

<h3><a name="categories_add">Добавление</a></h3>

<p><a href="/index.php?module=base&amp;action=help#categories_add">Основной раздел справки</a></p>

<h3><a name="categories_edit">Редактирование</a></h3>

<p><a href="/index.php?module=base&amp;action=help#categories_edit">Основной раздел справки</a></p>

<h3><a name="categories_del">Удаление</a></h3>

<p><a href="/index.php?module=base&amp;action=help#categories_del">Основной раздел справки</a></p>

<h2><a name="elements">Элементы списков меню</a></h2>

<h3><a name="elements_common">Общие сведения</a></h3>

<h3><a name="elements_add">Добавление</a></h3>

<ul>
<li>Название для показа пользователю может содержать любые символы. Оно может быть показано пользователю в списке меню и т. п.</li>
<li>Меню - каждый элемент относится к какому-либо меню.</li>
<li>Позиция - целое число; чем оно больше, тем ниже элемент в списке.</li>
<li>URL - адрес, на который будет ссылаться данный элемент.</li>
</ul>

<h3><a name="elements_edit">Редактирование</a></h3>

<ul>
<li>Название для показа пользователю может содержать любые символы. Оно может быть показано пользователю в списке меню и т. п.</li>
<li>Меню - каждый элемент относится к какому-либо меню.</li>
<li>Позиция - целое число; чем оно больше, тем ниже элемент в списке.</li>
<li>URL - адрес, на который будет ссылаться данный элемент.</li>
</ul>

<h3><a name="elements_del">Удаление</a></h3>

<h3><a name="elements_view_by_category">Просмотр по категориям</a></h3>

<p><a href="/index.php?module=base&amp;action=help#dataobject_view_by_category">Основной раздел справки</a></p>

<h2><a name="db">База данных</a></h2>

<h3><a name="db_common">Общие сведения</a></h3>

<p>В базе данных элементы хранятся в следующих таблицах:</p>

<ul>
<li>ksh_menu_categories - списки меню;</li>
<li>ksh_menu - элементы списков.</li>
</ul>

<h3><a name="db_tables_create">Создание таблиц</a></h3>

<p>При исполнении этого экшена создаются таблицы в базе данных.</p>

<h3><a name="db_tables_drop">Удаление таблиц</a></h3>

<p>При исполнении этого экшена даётся возможность удалить таблицы из базы данных - можно выбрать, какие.</p>

<h3><a name="db_tables_update">Обновление таблиц</a></h3>

<p>Этот экшен занимается обновлением таблиц базы данных, сохранившихся с более старых версий модуля.</p>
