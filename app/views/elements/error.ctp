<div id="aerrordiv" class="message <?php __($display); ?>">
	<span class="close" title="Dismiss" onclick="dismisserror();"></span>
	<p>
<?php 
	__($message); 
	if(isset($error_messages)){
		if(count($error_messages) > 0){
			print '<ul>';
			foreach($error_messages as $key=>$err){
				echo '<li>'.$err.'</li>';
			}	
			print '</ul>';				
		}
	}
?>
	</p>
</div>

