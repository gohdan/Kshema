<h1>����� �������� �����</h1>

<p>#result#</p>

<p>#content#</p>

<form action="/houses/search/type:#type#/id:#id#/page_template:#page_template#" method="post">
	����� �������: �� <input type="text" name="sq_from" size="3" value="#sq_from#"> �� <input type="text" name="sq_to" size="3" value="#sq_to#">
    <input type="submit" name="do_search" value="������">
</form>

<table>
#houses#
</table>
