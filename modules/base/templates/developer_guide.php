<h1>������ - ����������� ������������</h1>

<p><a href="/index.php?module=base&amp;action=admin">������� � �����������������</a></p>

<ul>
<li><a href="#module_creation">�������� ������</a></li>
<li>
<a href="#screen_output">����� �� �����</a>
<ul>
<li><a href="#output_itself">���������� �����</a></li>
<li><a href="#template_logic">������������� ������� � ��������</a></li>
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

<h2><a name="module_creation">�������� ������</a></h2>

<ol>
<li>���������������� ������ � ������ ������� ������� module_exists (/modules/modules/index.php)</li>
<li>������� ������� ��� ������ � /modules/</li>
<li>� ���� �������� ������� ���� index.php</li>
<li>���� ������ ������� �������, � index.php ����������� ������ �������������� ������� {�������� ������}_default_action; ��� ��� �����������, ����� ���������� � ������ (��������, � ������ news)</li>
<li>���� �����, ������� ������� templates � ������ ���� ������� ��� ������ ����������� ���������. ������������ ������� ���� ������� � ���� ���������� � ��������������� ��������� (/themes/{�������� ����}/templates/{�������� ������}/{�������� �������}.php; ���� �� �������, ���� ���� ������ � /modules/{�������� ������}/templates/{�������� �������}.php; ���� �� ������� � ���, ���� ��������� ������ �� ������ base.</li>
<li>���� ������ �������� �� ������ ��������� � ���� ������, ����� ������� ��������������� ���������� ��� �� ��������, ���������� � ��������; ����� ������ ����������� ���� db.php �� ������� ������ (��������, news). ��� ������������ � ������ ������ ���� ������� ksh_{�������� ������}_</li>
</ol>

<h2><a name="screen_output">����� �� �����</a></h2>

<h3><a name="output_itself">���������� �����</a></h3>

<p>
$content = gen_content(��������_������, ��������_�������, �������);
</p>

<p>
������:
</p>
<pre>
function hello()
{
    $content['content'] = "������";
    return $content;
}
$content = gen_content('registration', 'hello', hello());
</pre>

<p>
���� ���, ������ ��������� �������, ������� ���� ������ � ���������� ����������� � ����� ������ ��������.
</p>

<h3><a name="template_logic">������������� ������� � ��������</a></h3>

<p>
������:
</p>
<pre>
{{if:price:����: #price#}}
</pre>

<p>
���� ���������� $content['price'] ����������� � �� ����� "", ������������ 
����� ��������:
</p>
<pre>
����: #price#
</pre>
<p>
�����������, #price# ����� �������� �� $content['price'].
</p>

<p>
����� �� ����� �������� ������.
</p>

<p>�������, ������� ����� �������� ����� �������: a-zA-Z�-��-�0-9/ _&lt;&gt;=#:".)(

<h2><a name="api">API</a></h2>

<h3><a name="base">base</a></h3>

<h4><a name="functions_debug">debug</a></h4>

<p>���� ����� �������� � �������, ������� �������� �� �����.</p>

<p>debug (������ $string) ������� $string �� ����� (���������� - ������ ��� echo).
����� ������������� �����, ����� � /themes/��������_����/config.php ��������� $config['base']['debug'] �������� "on". 
���� ������ ����������, ����� ������������ ������ �������������� ��� ������������ � ID, ����������� � $config['base']['debug_user'] (�� ��������� - 1).
</p>

<h4><a name="functions_dump">dump</a></h4>

<p>���� ����� �������� � �������, ������� print_r ��������� �� �����.</p>

<h4><a name="functions_base_get_month_name">base_get_month_name</a></h4>

<p>���������� �������� ������ �� ��� ����������� ������.</p>

<h4><a name="functions_base_get_month_num">base_get_month_num</a></h4>

<p>���������� ���������� ����� ������ �� ��� ������������ ����������� ��������.</p>


<h3><a name="users">users</a></h3>

<h4><a name="functions_users_current_id">users_current_id</a></h4>

<p>users_current_id() - ���������� ID �������� ������������</p>

<h4><a name="functions_users_get_info">users_get_info</a></h4>

<p>users_get_info(����� $user_id) - �� ID ���������� ������ ���������� � ������������ � ���� �������������� �������</p>

