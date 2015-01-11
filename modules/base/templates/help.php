<h1>Основы - справка</h1>

<p><a href="/index.php?module=base&amp;action=admin">Обратно к администрированию</a></p>

<ul>
<li><a href="#common">Общие сведения</a></li>

<li><a href="#install">Установка</a>
<ul>
<li><a href="#install_db">Создание базы данных</a></li>
<li><a href="#install_base">Установка основной части</a></li>
<li><a href="#install_modules">Установка модулей</a></li>
</ul>
</li>

<li><a href="#categories">Категории</a>
<ul>
<li><a href="#categories_common">Общие сведения</a></li>
<li><a href="#categories_add">Добавление</a></li>
<li><a href="#categories_edit">Редактирование</a></li>
<li><a href="#categories_del">Удаление</a></li>
</ul>
</li>
<li><a href="#dataobject">Объекты данных</a>
<ul>
<li><a href="#dataobject_common">Общие сведения</a></li>
<li><a href="#dataobject_view_by_category">Просмотр по категориям</a></li>
</ul>
</li>
</ul>

<h2><a name="common">Общие сведения</a></h2>

<h2><a name="install">Установка</a></h2>

<h3><a name="install_db">Создание базы данных</a></h3>

<p>Базу данных пока приходится создавать вручную. Параметры соединения с ней указываются в /themes/{название темы - например, default}/db_config.php.</p>

<h3><a name="install_base">Установка основной части</a></h3>

<p>Зайдите на <a href="/index.php?module=base&amp;action=install">/index.php?module=base&amp;action=install</a>. 
Это создаст таблицу пользователей и запишет в неё администратора с логином gohdan@mail.ru и паролем tsoh.
После этого Вы получите приглашение ко входу и, войдя в качестве администратора, сможете установить остальные части системы.</p>

<h3><a name="install_modules">Установка модулей</a></h3>

<p>Установка модулей производится со страниц администрирования модулей (см. пункт "Создать таблицы базы данных").</p>

<h2><a name="categories">Категории</a></h2>

<h3><a name="categories_common">Общие сведения</a></h3>

<p>Категории позволяют объединять объекты данных в группы, которым потом можно назначать некоторые общие свойства:</p>

<ul>
<li>Шаблон всей страницы сайта при просмотре категории</li>
<li>Шаблон области просмотра категории</li>
<li>Шаблон списка элементов</li>
<li>Шаблон области просмотра элемента</li>
<li>Шаблон меню</li>
</ul>

<p>Категории могут быть подчиняться друг другу (количество уровней практически ничем не ограничено).</p>

<h3><a name="categories_add">Добавление</a></h3>

<ul>
<li>Системное название - должно состоять из латинских букв и цифр, может содержать знаки подчёркивания. Используется для идентификации 
категории в системе, составления URL.</li>
<li>Название для вывода пользователю может содержать любые символы. Используется для показа посетителям сайта, составления меню.</li>
<li>Шаблон всей страницы сайта при просмотре категории - по умолчанию - default. Должен состоять только из латинских букв, цифр, 
знаков подчёркивания. По содержимому этого поля отыскивается PHP-файл, содержащий шаблон всей страницы.</li>
<li>Шаблон области просмотра категории - по умолчанию - view_by_category. Должен состоять только из латинских букв, цифр, 
знаков подчёркивания. По содержимому этого поля отыскивается PHP-файл, содержащий шаблон области просмотра категории.</li>
<li>Шаблон списка элементов - по умолчанию - elements. Должен состоять только из латинских букв, цифр, 
знаков подчёркивания. По содержимому этого поля отыскивается PHP-файл, содержащий шаблон списка новостей.</li>
<li>Шаблон области просмотра элемента - по умолчанию - view. Должен состоять только из латинских букв, цифр, 
знаков подчёркивания. По содержимому этого поля отыскивается PHP-файл, содержащий шаблон области просмотра элемента.</li>
<li>Шаблон меню - по умолчанию - пустое поле. Должно состоять только из латинских букв, цифр, 
знаков подчёркивания. По содержимому этого поля отыскивается PHP-файл, содержащий шаблон меню.</li>
</ul>


<h3><a name="categories_edit">Редактирование</a></h3>

<ul>
<li>Системное название - должно состоять из латинских букв и цифр, может содержать знаки подчёркивания. Используется для идентификации 
категории в системе, составления URL.</li>
<li>Название для вывода пользователю может содержать любые символы. Используется для показа посетителям сайта, составления меню.</li>
<li>Шаблон всей страницы сайта при просмотре категории - по умолчанию - default. Должен состоять только из латинских букв, цифр, 
знаков подчёркивания. По содержимому этого поля отыскивается PHP-файл, содержащий шаблон всей страницы.</li>
<li>Шаблон области просмотра категории - по умолчанию - view_by_category. Должен состоять только из латинских букв, цифр, 
знаков подчёркивания. По содержимому этого поля отыскивается PHP-файл, содержащий шаблон области просмотра категории.</li>
<li>Шаблон списка элементов - по умолчанию - elements. Должен состоять только из латинских букв, цифр, 
знаков подчёркивания. По содержимому этого поля отыскивается PHP-файл, содержащий шаблон списка новостей.</li>
<li>Шаблон области просмотра элемента - по умолчанию - view. Должен состоять только из латинских букв, цифр, 
знаков подчёркивания. По содержимому этого поля отыскивается PHP-файл, содержащий шаблон области просмотра элемента.</li>
<li>Шаблон меню - по умолчанию - пустое поле. Должно состоять только из латинских букв, цифр, 
знаков подчёркивания. По содержимому этого поля отыскивается PHP-файл, содержащий шаблон меню.</li>
</ul>

<h3><a name="categories_del">Удаление</a></h3>

<p>При удалении категории удаляются также и все принадлежащие к ней элементы.</p>

<h2><a name="dataobject">Объекты данных</a></h2>

<h3><a name="dataobject_common">Общие сведения</a></h3>

<p>Объект данных - любая структура данных, содержащаяся в базе данных. На базе объектов данных можно строить публикации. 
Объекты данных можно организовывать в категории для присвоения им некоторых общих свойств (шаблоны страниц и т. п.).</p>

<h3><a name="dataobject_view_by_category">Просмотр по категориям</a></h3>

<p>Просмотр содержащихся в категории объектов данных.</p>


