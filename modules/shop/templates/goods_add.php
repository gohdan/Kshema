<h1>���������� �������</h1>

<p><a href="/shop/goods_view_all/">� ��������� �������</a></p>

<hr>

<p>#result#</p>

<p>#content#</p>

<p>������������� ������ � ���������� � ������ �� ������������.</p>

<form action="/shop/goods_add/" method="post" enctype="multipart/form-data">

<table>

<tr><td>�����������:</td><td><input type="file" name="image"></td></tr>
<tr><td>�������������� �����������:</td><td><input type="file" name="images"></td></tr>
<tr><td>�������� ������:</td><td><input type="text" name="name" size="30"></td></tr>
<tr><td>�����:</td><td><select name="author">
#authors#
</select></td></tr>
<tr><td>���������:</td><td><select name="category">
#categories#
</select></td></tr>
<tr><td>����� (����� �������):</td><td><input type="text" name="tags" size="60"></td></tr>
<tr><td>PDF:</td><td><input type="file" name="pdf"></td></tr>
<tr><td>epub:</td><td><input type="file" name="epub"></td></tr>
<tr><td>MP3:</td><td><input type="file" name="mp3"></td></tr>

<tr><td>����:</td><td><input type="text" name="genre" size="30"></td></tr>
<tr><td>������������ ��������:</td><td><input type="text" name="original_name" size="30"></td></tr>
<tr><td>������:</td><td><input type="text" name="format"></td></tr>
<tr><td>����:</td><td><input type="text" name="language"></td></tr>
<tr><td>��� ����������:</td><td><input type="text" name="year"></td></tr>
<tr><td>������������:</td><td><input type="text" name="publisher"></td></tr>
<tr><td>���������� �������:</td><td><input type="text" name="pages_qty"></td></tr>
<tr><td>��� (������ �����!):</td><td><input type="text" name="weight"></td></tr>


<tr><td>���������� (������ �����!):</td><td><input type="text" name="new_qty"></td></tr>
<tr><td>���� (������ �����!):</td><td><input type="text" name="new_price"></td></tr>

<tr><td>�����</td><td><input type="checkbox" name="if_new" value="1"></td></tr>
<tr><td>����������</td><td><input type="checkbox" name="if_popular" value="1"></td></tr>
<tr><td>�������������</td><td><input type="checkbox" name="if_recommend" value="1"></td></tr>
<tr><td>������</td><td><input type="checkbox" name="if_hide" value="1"></td></tr>

<tr><td>�������� ������:<br><span style="font-size: 70%; font-style: italic">(�������������� ����� �������� ��� ��������������)</span></td><td><input type="text" name="new_link_title" size="30"> ���������<br>
<input type="text" name="new_link_img" size="30"> �����������<br>
<input type="text" name="new_link_url" size="30"> ������</td>
</tr>

<!--
�/� ����������:<br>
����������: <input type="text" name="used_qty"><br>
����: <input type="text" name="used_price"><br>
<hr>
-->

<tr><td colspan="2">embed:<br>
<textarea name="embed"></textarea></td></tr>
<tr><td colspan="2">�����������:<br>
<textarea name="commentary"></textarea></td></tr>

</table>

<input type="submit" name="do_add" value="��������">
</form>

