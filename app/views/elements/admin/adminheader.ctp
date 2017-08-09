<?php echo $html->docType('xhtml-trans'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<title><?php __(Configure::read('sitename'));?> - Administration</title>
	<?php echo $html->css(array('admin/layout','admin/themes','admin/dateinput','admin/form')); ?>
	<?php  echo $html->css(array('admin/print'), 'stylesheet', array('media' => 'print'));?>
	<?php echo $javascript->link(array('scriptpath','jquery','scripts','jquery.tools.min.js')); ?>
	<link rel="icon" href="<?php echo $html->url('/img/favicon.ico'); ?>" type="image/x-icon" />
	<link rel="shortcut icon" href="<?php echo $html->url('/img/favicon.ico'); ?>" type="image/x-icon" />
</head>
<body>
<div class="pageWrapper">
	<div class="pageHeader">
		<div class="logo">
			<h1><?php __($html->link('Administration Console', array('controller'=>'admins','action'=>'dashboard'),array('alt'=>'Administration Console','title'=>'Administration Console'))); ?></h1>
			<?php __($html->link('Back to website', Configure::read('PARENT_WEB_URL'),array('class'=>'viewWebsite curveEdges','target'=>'_blank','title'=>Configure::read('sitename')))); ?>
		</div>
		<div class="loginInfos"> 
			<p>Hello <strong><?php __($admindata['Admin']['name']); ?></strong>&nbsp;&nbsp;|&nbsp;&nbsp;
			<?php __($html->link('Edit settings', array('controller'=>'admins','action'=>'settings'),array('title'=>'Edit settings'))); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php __($html->link('Logout', array('controller'=>'admins','action'=>'logout'),array('title'=>'Logout'))); ?></p><p>Last Login: <?php __($admindata['Admin']['lastlogin']); ?></p>
		</div>