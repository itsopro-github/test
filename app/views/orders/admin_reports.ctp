<?php echo $html->css(array('ui.all')); ?>
<?php echo $html->css(array('ui.core')); ?>
<?php e($javascript->link('ui.datepicker')); ?>
<script type="text/javascript">$(function(){$('#Date01').datepicker();});$(function(){$('#Date1').datepicker();});$(function(){$('#Date2').datepicker();});$(function(){$('#Date3').datepicker();});$(function(){$('#Date4').datepicker();});$(function(){$('#Date5').datepicker();});$(function(){$('#Date6').datepicker();});$(function(){$('#Date7').datepicker();});$(function(){$('#Date8').datepicker();});$(function(){$('#Date9').datepicker();});$(function(){$('#Fromdate1').datepicker();});$(function(){$('#Todate1').datepicker();});$(function(){$('#Fromdate2').datepicker();});$(function(){$('#Todate2').datepicker();});$(function(){$('#Fromdate3').datepicker();});$(function(){$('#Todate3').datepicker();});$(function(){$('#Fromdate4').datepicker();});$(function(){$('#Todate4').datepicker();});$(function(){$('#Fromdate5').datepicker();});$(function(){$('#Todate5').datepicker();});$(function(){$('#Fromdate6').datepicker();});$(function(){$('#Todate6').datepicker();});$(function(){$('#Fromdate7').datepicker();});$(function(){$('#Todate7').datepicker();});$(function(){$('#Fromdate8').datepicker();});(function(){$('#Todate8').datepicker();});$(function(){$('#Fromdate9').datepicker();});$(function(){$('#Todate9').datepicker();});</script>
<?php $paginator->options(array('url' => $this->passedArgs)); ?> 
<?php 
	$html->addCrumb("Reports", array());
	pr($this->params['type']);
	if($admindata['Admin']['type']!='E') {
?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header"><h1 class="fleft"><?php __('Reports');?></h1></div>
		<div class="header1">
			<ul>
				<li><?php __($html->link('Total Requests', array('controller'=>'orders','action'=>'reports', 'type'=>'requests'),array('class'=>($this->params['type']=='requests' || $this->params['type']=='') ? 'curr-tab' : 'all','alt'=>'Total # of requests received','title'=>'Total # of requests received'))); ?></li>
				<li><?php __($html->link(__('NO SIGNS', true), array('controller'=>'orders','action'=>'reports', 'type'=>'nosigns'),array('class'=>($this->params['type']=='nosigns') ? 'curr-tab' : 'all','alt'=>'Total # of NO SIGNS','title'=>'Total # of NO SIGNS'))); ?></li>
				<li><?php __($html->link(__('COMPLETED Signings', true), array('controller'=>'orders','action'=>'reports', 'type'=>'completed'),array('class'=>($this->params['type']=='completed') ? 'curr-tab' : 'all','alt'=>'Total # of COMPLETED signings','title'=>'Total # of COMPLETED signings'))); ?></li>
				<li><?php __($html->link(__('Total Signings by Notary', true), array('controller'=>'orders','action'=>'reports', 'type'=>'signings'),array('class'=>($this->params['type']=='signings') ? 'curr-tab' : 'all','alt'=>'Total # of signings a notary has completed','title'=>'Total # of signings a notary has completed'))); ?></li>
				<li><?php __($html->link(__('Mistakes', true), array('controller'=>'orders','action'=>'reports', 'type'=>'mistakes'),array('class'=>($this->params['type']=='mistakes') ? 'curr-tab' : 'all','alt'=>'Total # of mistakes specific notaries have completed (per incidents)','title'=>'Total # of mistakes specific notaries have completed (per incidents)'))); ?></li>
				<li><?php __($html->link(__('Notaries', true), array('controller'=>'orders','action'=>'reports', 'type'=>'notaries'),array('class'=>($this->params['type']=='notaries') ? 'curr-tab' : 'all','alt'=>'Number of Notaries','title'=>'Number of Notaries'))); ?></li>
				<li><?php __($html->link(__('Source of Entry', true), array('controller'=>'orders','action'=>'reports', 'type'=>'source'),array('class'=>($this->params['type']=='source') ? 'curr-tab' : 'all','alt'=>'How did you hear about us','title'=>'How did you hear about us'))); ?></li>
			</ul>
		</div>
<?php
		$reporttype = (isset($this->params['type'])) ? $this->params['type'] : 'requests';
		switch ($reporttype) {
			case 'requests':
				__($this->element('admin/generatereport', array('reporttitle'=>'Total # of requests received', 'hour'=>'yes', 'date'=>'yes','from'=>'yes','to'=>'yes', 'month'=>'yes','year'=>'yes','company'=>'yes','notary'=>'no','notarytype'=>'no','search'=>1,'status'=>'0','howhear'=>'no','howheartype'=>'no','searchtype'=>'fr', 'reporttype'=>$reporttype)));
				break;
			
			case 'nosigns':
				__($this->element('admin/generatereport', array('reporttitle'=>'Total # of NO SIGNS',  'date'=>'yes','from'=>'yes','to'=>'yes', 'month'=>'yes','year'=>'yes','company'=>'yes', 'notary'=>'no','notarytype'=>'no','search'=>2,'status'=>'5','howhear'=>'no','howheartype'=>'no','searchtype'=>'fr', 'reporttype'=>$reporttype)));
				break;
				
			case 'completed':
				__($this->element('admin/generatereport', array('reporttitle'=>'Total # of COMPLETED signings', 'date'=>'yes','from'=>'yes','to'=>'yes', 'month'=>'yes','year'=>'yes','company'=>'yes', 'notary'=>'no','notarytype'=>'no','search'=>3,'status'=>'7','howhear'=>'no','howheartype'=>'no','searchtype'=>'fr', 'reporttype'=>$reporttype)));
				break;
				
			case 'signings':
				__($this->element('admin/generatereport', array('reporttitle'=>'Total # of signings a notary has completed', 'date'=>'yes','from'=>'yes','to'=>'yes', 'month'=>'yes','year'=>'yes','company'=>'no','notary'=>'yes','notarytype'=>'no','search'=>4,'status'=>'0','howhear'=>'no','howheartype'=>'no','searchtype'=>'nr', 'reporttype'=>$reporttype)));
				break;
				
			case 'mistakes':
				__($this->element('admin/generatereport', array('reporttitle'=>'Total # of mistakes specific notaries have completed (per incidents)', 'date'=>'no','from'=>'no','to'=>'no', 'month'=>'no','year'=>'no','company'=>'no','notary'=>'yes','notarytype'=>'no','howheartype'=>'no','search'=>5,'status'=>'0','howhear'=>'no','searchtype'=>'nr', 'reporttype'=>$reporttype)));
				break;
				
			case 'notaries':
				__($this->element('admin/generatereport', array('reporttitle'=>'Number of Notaries', 'date'=>'yes','from'=>'yes','to'=>'yes', 'month'=>'yes','year'=>'yes','company'=>'no','notary'=>'no','notarytype'=>'yes','search'=>6,'status'=>'0','howhear'=>'no','howheartype'=>'no','searchtype'=>'nr', 'reporttype'=>$reporttype)));
				break;
				
			case 'source':
				__($this->element('admin/generatereport', array('reporttitle'=>'Total # - How did you hear about us', 'date'=>'yes','from'=>'yes','to'=>'yes', 'month'=>'yes','year'=>'yes','company'=>'no','notary'=>'no','notarytype'=>'no','howhear'=>'yes','howheartype'=>'yes','search'=>7,'status'=>'0','searchtype'=>'nr', 'reporttype'=>$reporttype)));
				break;
				
			default:
				__($this->element('nopermission'));
				break;
		}
	} else {
		__($this->element('nopermission')); 
	}
?>
	</div>
</div>