<?php __($this->element('header')); ?>
<div class="header_text_bg">
    <div class="header_text2">
   		<div class="aerrordiv"><?php echo $session->flash(); ?></div>
	    <h2><?php __($title_for_layout); ?></h2>
   		<div class="clr"></div>
    </div>
</div>
<div class="body_resize">
	<div class="body">
		<div class="body_small">
        	<?php if(isset($usersession)) {__($this->element('myaccountnav'));} ?>
        	<?php __($this->element('newsandevents')); ?>
        	<?php __($this->element('getintouch')); ?>
			<?php __($this->element('followus')); ?>
		</div>
		<div class="body_big"><?php __($content_for_layout); ?></div>
		<div class="clr"></div>
	</div>
</div>
<?php __($this->element('footer')); ?>