<h1>�������������� �������</h1>

<a href="/index.php?module=projects&action=view_categories">��������� ��������</a>

<p>#result#</p>

<p>#content#</p>

<form action="/index.php?module=projects&action=edit" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="#id#">
    <input type="hidden" name="old_image" value="#image#">
    ��������� �������� (��������� ����� � �����): <input type="text" name="name" value="#name#"><br>
	�������� ��� ������������ (����� �������): <input type="text" name="title" value="#title#"><br>
    ���������:
    <select name="category">
    #categories_select#
    </select><br>
    <img src="#image#"><br>
    ����� �����������-��������: <input type="file" name="image">
    <br>
    ��������:<br>
    <textarea cols="40" rows="10" name="descr">#descr#</textarea><br>
    <input type="submit" name="do_update" value="��������">
</form>