	<div class="footer">
		<div class="footer_resize">
			<p class="leftt"><b>&copy; Copyright <?=date('Y')?> /<?php __($html->link(Configure::read('sitename'), Configure::read('PARENT_WEB_URL'))); ?> / All Rights Reserved</b></p>
		</div>
	</div>
</div>
<?php __($this->element('sql_dump')); ?>
</body></html>