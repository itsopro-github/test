<?php echo $html->docType('xhtml-trans'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php __(Configure::read('sitename')); ?></title>
		<?php echo $html->charset(); ?>
	</head>
	<body>
		<table width="500">	
	      	<tr><td class="logo"><?php __($html->image('logo.png'), array('alt'=>Configure::read('sitename'),'alt'=>Configure::read('sitename'))); ?></td></tr>
	      	<tr><td align="right"><a style="cursor:pointer;" onclick="window.print();">print</a> | <a style="cursor:pointer;" onclick="window.close();">close</a></td></tr>
			<tr><td><?php __($content_for_layout); ?></td></tr>
		</table>
	</body>
</html>