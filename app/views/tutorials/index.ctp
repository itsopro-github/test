<div class="orders index">
	<div>
		<?php __($html->clean(nl2br($contentpage['Contentpage']['content']))); ?>
	</div>
	<div class="block">
<?php
		foreach ($tutorials as $tutorial):
			$class = null;
			if($tutorial['Tutorial']['category'] == $usersession['User']['type']) {
?>				
				<div class="titler"><div class="title"><h3 class="fleft"><?php __($tutorial['Tutorial']['title']); ?></h3></div><div class="titleactions"><span>Created on <?php __($counter->formatdate('nsdatetime',$tutorial['Tutorial']['created'])); ?></span></div></div>
				<div class="clear">
				<object id="player" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" name="player" width="600" height="350"><param name="movie" value="<?php __(Configure::read('WEB_URL'));?>img/player.swf" /><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="flashvars" value="file=<?php __(Configure::read('WEB_URL').Configure::read('TUTORIAL_PATH').$tutorial['Tutorial']['tutorialfile']); ?>&image=<?php __(Configure::read('WEB_URL')); ?>img/logo.png" /><embed type="application/x-shockwave-flash" id="player2" name="player2" src="<?php __(Configure::read('WEB_URL'));?>img/player.swf" width="600" height="350" allowscriptaccess="always" allowfullscreen="true" flashvars="file=<?php __(Configure::read('WEB_URL').Configure::read('TUTORIAL_PATH').$tutorial['Tutorial']['tutorialfile']); ?>&image=<?php __(Configure::read('WEB_URL')); ?>img/logo.png" /></object></div>
				<div><p><?php __($tutorial['Tutorial']['description']); ?></p></div>
		<?php 
			}
		endforeach;
		?>		
		<div>
		
		<?php
		if(!$tutorials) {
			__($this->element('nobox', array('displaytext'=>'No tutorials found')));
		}
		?>
		</div>
	</div>
</div>