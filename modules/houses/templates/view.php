<script language="javascript">

$v = '#1floor#';

function show_1()
{
	document.images['plan'].src='#1floor_t#';
    $v = '#1floor#';
}

function show_2()
{
	document.images['plan'].src='#2floor_t#';
    $v = '#2floor#';
}

function showimg()
{
	myWin= open($v, "displayWindow", "status=no,toolbar=no,menubar=no,resizable=yes")
}

</script>

<table class="project_main_layout">
<tr>
<td class="project_plans">

<table width="100%">
<tr>
	<td>
    	<table class="project_image">
        <tr>
        	<td class="project_corner_upleft"></td>
            <td class="project_rubber_up"></td>
            <td class="project_corner_upright"></td>
        </tr>
        <tr>
        	<td class="project_rubber_left"></td>
            <td class="project_image"><img src="#3d#"></td>
            <td class="project_rubber_right"></td>
        </tr>
        <tr>
        	<td class="project_corner_downleft"></td>
            <td class="project_rubber_down"></td>
            <td class="project_corner_downright"></td>
        </tr>
        </table>
        
        

    	<table class="project_image">
        <tr>
        	<td class="project_corner_upleft"></td>
            <td class="project_rubber_up"></td>
            <td class="project_corner_upright"></td>
        </tr>
        <tr>
        	<td class="project_rubber_left"></td>
            <td class="project_image"><IFRAME src="#fasad#" width="395" marginheight="0" marginwidth="0" scrolling="auto" frameborder="0"></IFRAME></td>
            <td class="project_rubber_right"></td>
        </tr>
        <tr>
        	<td class="project_corner_downleft"></td>
            <td class="project_rubber_down"></td>
            <td class="project_corner_downright"></td>
        </tr>
        </table>
    </td>
    <td>
    	��������, ����� ���������
	   	<table class="project_image">
        <tr>
        	<td class="project_corner_upleft"></td>
            <td class="project_rubber_up"></td>
            <td class="project_corner_upright"></td>
        </tr>
        <tr>
        	<td class="project_rubber_left"></td>
            <td class="project_image"><img src="#1floor_t#" name="plan" class="button" onclick="javascript: showimg()"></td>
            <td class="project_rubber_right"></td>
        </tr>
        <tr>
        	<td class="project_corner_downleft"></td>
            <td class="project_rubber_down"></td>
            <td class="project_corner_downright"></td>
        </tr>
        </table>
    </td>
</tr>
</table>

</td>
</tr>
<tr>
<td class="project_info">


<table class="project_info">
<tr>
	<td class="project_properties">
	
		<h1>#name#</h1>
	    <div class="project_properties">
        {{if:price:��������� ���������: #price# ���.<br>}}
		{{if:sq_common:����� �������: #sq_common# �2<br>}}
		{{if:sq_balcones:� �. �. ������� � �������: #sq_balcones# �2<br>}}
		{{if:sq_living:����� �������: #sq_living# �2}}
        </div>
		{{if:composition:<div class="project_composition"><b>������ �������� ���������:</b><br> #composition#</div>}}
    </td>
    <td class="project_links">
    	<p>
        <img src="/themes/tamak/images/project_open_1st.gif" alt="������� ���� 1 �����" width="159" height="31" class="button" onclick="javascript: show_1()">
        {{if:2floor:<img src="/themes/tamak/images/project_open_2nd.gif" alt="������� ���� 2 �����" width="160" height="31" class="button" onclick="javascript: show_2()">}}
		{{if:pdf:<a href="#pdf#"><img src="/themes/tamak/images/project_open_pdf.gif" alt="������� ������ � PDF" width="160" height="31"></a>}}
        </p>
<!--        <p><a href="/houses/view_by_category/#category_id#/">��� ������� �� ��������� <br>"#category#"</a></p> -->
		

		<p>#edit_link#</p>
		<p>#del_link#</p>
        
        <div class="return">
		<a href="/"><img src="/themes/tamak/images/project_logo.gif"></a>
        </div>
        
        <div class="warning">
        ��� ��������� ������ JavaScript ������ ���� �������
        </div>

    </td>
</tr>
</table>

</td>
</tr>
</table>

