
{{if:title:<h2>#brand# #model# #width#/#profile#/#radius# #speed_short#</h2>}}

{{if:no_tire:<p>��� ����� ������</p>}}

<div class="row">

<div class="span4 well">

<h3>�������� ������</h3>

{{if:price:<p>����: <b>#price# ���.</b></p>}}
{{if:brand:�����: <a href="/shiny/x/x/x/#brand_url#/x/x/x/x/">#brand#</a><br>}}
{{if:source:�������������: <a href="/shiny/#source_url#/x/x/x/x/x/x/x/">#source#</a><br>}}
{{if:season:�����: <a href="/shiny/x/#season_url#/x/x/x/x/x/x/">#season#</a><br>}}
{{if:spikes:����������: <a href="/shiny/x/x/#spikes_url#/x/x/x/x/x/">#spikes#</a><br>}}
{{if:speed:��������: #speed#<br>}}
{{if:profile:�������: <a href="/shiny/x/x/x/x/x/#profile_url#/x/x/">#profile#</a><br>}}
{{if:radius:������� (R): <a href="/shiny/x/x/x/x/x/x/#radius_url#/x/">#radius#</a><br>}}
{{if:width:������: <a href="/shiny/x/x/x/x/x/x/x/#width_url#/">#width#</a><br>}}
</div>

{{if:has_analogs:
<div class="span7 well">
<h3>� ���� �� ����������� ����� ������:</h3>
#analogs#
}}

{{if:has_analogs_hidden:
<span id="tires_show_analogs" class="btn-link tires_show_analogs" onClick="javascript:tires_analogs_show()">�������� ��� ������ (����� #analogs_hidden_qty#)</span>
<div id="tires_analogs" class="tires_analogs">
#analogs_hidden#
</div>
}}

{{if:has_analogs:
</div>
}}

</div>

{{if:has_tire:
<h2>��������:</h2>

<table class="table table-bordered table-striped table-hover">
<tr>
<th>��������</th><th>�������</th><th>����</th><th>�������</th><th></th>
</tr>
<tr>
<td>inozap.ru</td><td>8-800-333-82-33 ���������� 333</td><td>#price# ���. (������ ��� ��������� � tamboff.ru)</td><td>4 ������� ���</td><td><!--noindex--><a href="http://inozap.axxi.ru/?rn=#rn#&k=tamboff" rel="nofollow">��������</a><!--/noindex--></td>
</tr>
</table>

}}
