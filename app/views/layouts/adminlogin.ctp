<?php echo $html->docType('xhtml-trans'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $html->charset(); ?>
<title><?=Configure::read('sitename')?> - Administration</title>
<?php echo $html->css(array('admin/layout','admin/themes','admin/form')); ?>
<link rel="icon" href="<?php echo $html->url('/img/favicon.ico'); ?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo $html->url('/img/favicon.ico'); ?>" type="image/x-icon" /> 
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="logintable">
  	<tr>
    <td height="550" valign="middle">
	    <div class="block">
	    	<div class="block_content">
			    <div class="adminlogin">
			    	<div class="errordiv"><?php echo $session->flash(); ?></div>
					<?php echo $content_for_layout ?> 
		     	</div>
	     	</div>
	    </div>
    </td>
  	</tr>
</table>
<?php __($this->element('sql_dump')); ?>
</body>
</html>