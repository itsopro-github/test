<?php if(!isset($_POST['saddr'])) { ?>
<div style="display:none">
<form action="http://maps.google.com/maps" method="get" name='form1'>
<input type="text" name="saddr" id="saddr" value="<?=$_GET['zip1']?>" />
<input type="hidden" name="daddr" value="<?=$_GET['zip2']?>" />
<input type="hidden" name="hl" value="en" /></p>
</form>
</div>
<script>document.form1.submit();</script>
<?php } ?>
