<?php echo $html->docType('xhtml-trans'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php __(Configure::read('sitename')); ?> <?php __(@$contentpage['Contentpage']['pagetitle']); ?></title>
	<?php echo $html->charset(); ?>
	<?php echo $html->meta('keywords', @$contentpage['Contentpage']['metakey']);?>
	<?php echo $html->meta('description',@$contentpage['Contentpage']['metadesc']);?>
	<?php echo $html->css(array('style','dateinput')); ?>
	<?php echo $javascript->link(array('scriptpath','jquery','scripts','jquery.tools.min.js')); ?>
	<link rel="icon" href="<?php echo $html->url('/favicon.ico'); ?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo $html->url('/favicon.ico'); ?>" type="image/x-icon" />
</head>
<body>
<div class="main">
  	<div class="blok_header">
    	<div class="header">
      		<div class="logo"><?php __($html->link($html->image('logo.jpg',array('alt'=>Configure::read('sitename'),'title'=>Configure::read('sitename'))), Configure::read('PARENT_WEB_URL'),array('escape'=>false)));?></div>
			<div class="clr"></div>
     		<?php __($this->element('navigation', array('usersession'=>@$usersession))); ?>
  		</div>