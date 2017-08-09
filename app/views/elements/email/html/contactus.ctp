<p>Contact us - <?php __(Configure::read('sitename')); ?><br /><hr><br />
<b>Details of <?php __($mailuserdata['News']['name']); ?> </b><br /><br />
 Name: <?php __($mailuserdata['News']['name']); ?><br /><br />
 Email address: <?php __($mailuserdata['News']['email']); ?><br /><br />
 Company: <?php __($mailuserdata['News']['company']); ?><br /><br />
 Subject: <?php __($mailuserdata['News']['subject']); ?><br /><br /> 
 Message: <?php __(nl2br($mailuserdata['News']['message'])); ?><br /><br /> <br />
</p>
<br /><br />