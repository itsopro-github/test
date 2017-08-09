<p></p>
<div class="assignments view">
	<div class="block">
		<p>Name: <?php __($assignment['Order']['first_name']." ".$assignment['Order']['last_name']); ?></p>
		<p>Details: <?php __(nl2br($assignment['Assignment']['details'])); ?></p>
		<p>Assigned date: <?php __($counter->formatdate('nsdate',$assignment['Assignment']['created'])); ?></p>
	</div>
</div>