<h1>�������������� ������</h1>

<p><a href="/shop/goods_view_all/">� ��������� �������</a></p>

<p><a href="/shop/view_good/good:#id#" target="_view_#id#">���������� ���� �����</a></p>

<hr>

<p>#result#</p>

<p>#content#</p>

<p>������������� ������ � ���������� � ������ �� ������������.</p>

<form action="/shop/goods_edit/goods:#id#/" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="#id#">
<input type="hidden" name="image" value="#image#">
<input type="hidden" name="pdf" value="#pdf#">
<input type="hidden" name="if_new" value="0">
<input type="hidden" name="if_popular" value="0">
<input type="hidden" name="if_recommended" value="0">
<input type="hidden" name="if_hide" value="0">

<table>
{{if:image:<tr><td>�����������:</td><td><img src="#image#" align="top"></td></tr>}}

<tr><td>����� �����������:</td><td><input type="file" name="image"></td></tr>

{{if:images:<tr><td>�������������� �����������:</td><td><img src="#images#" align="top"><br><input type="checkbox" name="images_del" value="1"> �������</td></tr>}}

<tr><td>����� �������������� �����������:</td><td><input type="file" name="images"></td></tr>

<tr><td>�������� ������:</td><td><input type="text" name="name" size="30" value="#name#"></td></tr>
<tr><td>�����:</td><td><select name="author">
#authors#
</select></td></tr>
<tr><td>���������:</td><td><select name="category">
#categories#
</select></td></tr>
<tr><td>����� (����� �������):</td><td><input type="text" name="tags" size="60" value="#tags#"></td></tr>
{{if:pdf:<tr><td>PDF:</td><td><a href="#pdf#">�������</a> <input type="checkbox" name="pdf_del" value="1"> �������</td></tr>}}
<tr><td>�������� PDF:</td><td><input type="file" name="pdf"></td></tr>
{{if:epub:<tr><td>epub:</td><td><a href="#epub#">�������</a> <input type="checkbox" name="epub_del" value="1"> �������</td></tr>}}
<tr><td>�������� epub:</td><td><input type="file" name="epub"></td></tr>
{{if:mp3:<tr><td>MP3:</td><td><a href="#mp3#">�������</a> <input type="checkbox" name="mp3_del" value="1"> �������</td></tr>}}
<tr><td>�������� MP3:</td><td><input type="file" name="mp3"></td></tr>
<tr><td>����:</td><td><input type="text" name="genre" size="30" value="#genre#"></td></tr>
<tr><td>������������ ��������:</td><td><input type="text" name="original_name" size="30" value="#original_name#"></td></tr>
<tr><td>������:</td><td><input type="text" name="format" value="#format#"></td></tr>
<tr><td>����:</td><td><input type="text" name="language" value="#language#"></td></tr>
<tr><td>������������:</td><td><input type="text" name="publisher" value="#publisher#"></td></tr>

<tr><td>��� ����������:</td><td><input type="text" name="year" value="#year#"></td></tr>
<tr><td>���������� �������:</td><td><input type="text" name="pages_qty" value="#pages_qty#"></td></tr>

<tr><td>��� (������ �����!):</td><td><input type="text" name="weight" value="#weight#"></td></tr>
<tr><td>���������� (������ �����!):</td><td><input type="text" name="new_qty" value="#new_qty#"></td></tr>
<tr><td>���� (������ �����!):</td><td><input type="text" name="new_price" value="#new_price#"></td></tr>

<tr><td>�����</td><td><input type="checkbox" name="if_new" value="1"{{if:if_new: checked}}</td></tr>
<tr><td>����������</td><td><input type="checkbox" name="if_popular" value="1"{{if:if_popular: checked}}></td></tr>
<tr><td>�������������</td><td><input type="checkbox" name="if_recommended" value="1"{{if:if_recommended: checked}}></td></tr>
<tr><td>������</td><td><input type="checkbox" name="if_hide" value="1"{{if:if_hide: checked}}></td></tr>

<tr><td colspan="2">������:</td></tr>
#links_edit#
<tr><td>�������� ������:</td>
<td><input type="text" name="new_link_title" size="30"> �����<br>
<input type="text" name="new_link_img" size="30"> �����������<br>
<input type="text" name="new_link_url" size="30"> ������</td></tr>


<!--
�/� ����������:<br>
����������: <input type="text" name="used_qty" value="#used_qty#"><br>
����: <input type="text" name="used_price" value = "#used_price#"><br>
<hr>
-->

<tr><td colspan="2">embed:<br>
<textarea name="embed">#embed#</textarea></td></tr>
<tr><td colspan="2">�����������:<br>
<textarea name="commentary">#commentary#</textarea></td></tr>
</table>
<input type="submit" name="do_update" value="��������">
</form>

