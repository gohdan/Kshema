<h1>������� ������</h1>

#content#

<p>
<a href="/modules/admin/">������� � ������ �������</a><br>
<a href="/uploads/help/">�������</a>
</p>

<form action="/uploads/admin/" method="post" enctype="multipart/form-data">
	��� ����������:<br>
	<input type="radio" name="type" value="uploads"{{if:type_uploads: checked}}>������ ����<br>
	<input type="radio" name="type" value="news"{{if:type_news: checked}}>����������� ��� ������������� � ��������<br>
	<input type="radio" name="type" value="articles"{{if:type_articles: checked}}>����������� ��� ������������� � �������<br>
	<input type="radio" name="type" value="banners"{{if:type_banners: checked}}>������<br>
    ����: <input type="file" name="image">
    <input type="submit" name="do_upload" value="��������">
</form>

<h2>����������������� ���� ������ �������</h2>

<p>
<a href="/uploads/create_tables/">������� ������� ���� ������</a><br>
<a href="/uploads/drop_tables/">���������� ������� ���� ������</a><br>
<a href="/uploads/update_tables/">�������� ������� ���� ������</a>
</p>
