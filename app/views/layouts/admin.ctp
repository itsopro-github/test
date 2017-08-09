		<?php __($this->element('admin/adminheader')); ?>
		<div class="mainNav clear">
			<?php __($this->element('admin/adminnav')); ?>
			
		</div>
		<?php __($this->element('admin/adminbreadcrumb')); ?>
	</div>
	<div class="aerrordiv"><?php echo $session->flash(); ?></div>
	<div id="contentwrap" class="contentWrapper"><?php __($content_for_layout); ?></div>
	<div class="pageFooter"><p><?php __(Configure::read('copyright'));?></p></div>
</div>
<?php __($this->element('sql_dump')); ?>
</body>
</html>
