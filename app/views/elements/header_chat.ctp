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
      		<div class="logo"><?php __($html->link($html->image('logo.png',array('alt'=>Configure::read('sitename'),'title'=>Configure::read('sitename'))),'/',array('escape'=>false)));?></div>
<div class="click">
<div id="ci2pws" style="z-index:100;position:absolute"></div><div id="sc2pws" style="display:inline"></div><div id="sd2pws" style="display:none"></div><script type="text/javascript">var se2pws=document.createElement("script");se2pws.type="text/javascript";var se2pwss=(location.protocol.indexOf("https")==0?"https":"http")+"://image.providesupport.com/js/wbsw/safe-textlink.js?ps_h=2pws&ps_t="+new Date().getTime()+"&online-link-html=Live%20Chat%20Online&offline-link-html=Live%20Chat%20Offline";setTimeout("se2pws.src=se2pwss;document.getElementById('sd2pws').appendChild(se2pws)",1)</script><noscript><div style="display:inline"><a href="http://www.providesupport.com?messenger=wbsw">Customer Support</a></div></noscript><br>Toll Free <?php __(Configure::read('tollfreenumber')); ?></div><div class="clr"></div>
     		<?php __($this->element('navigation', array('usersession'=>@$usersession))); ?>
  		</div>