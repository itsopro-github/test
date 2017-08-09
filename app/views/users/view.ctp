<div class="orders index">
	<div class="block">
		<table cellspacing="0" cellpadding="0" border="0" width="100%" class="tableview">
			<tr>
				<th><?php __('First Name'); ?> </th> <td class="first_row"><?php echo $user['Notary']['first_name']; ?></td>
			</tr>
			<tr>
				<th><?php __('Last Name'); ?> </th> <td class="first_row"><?php echo $user['Notary']['last_name']; ?></td>
			</tr>
			<tr>
				<th><?php __('Email Address'); ?> </th> <td class="first_row"><?php echo $user['Notary']['email'] ?></td>
			</tr>	
			<tr>
				<th><?php __('Cell Phone'); ?> </th> <td class="first_row">
				  <?php echo  substr($user['Notary']['cell_phone'],0,3).'-'.substr($user['Notary']['cell_phone'],3,3).'-'.substr($user['Notary']['cell_phone'],6,4); ?>
			
				</td>
			</tr>
			<tr>
				<th><?php __('Day Phone'); ?> </th> <td class="first_row">
				  <?php echo  substr($user['Notary']['day_phone'],0,3).'-'.substr($user['Notary']['day_phone'],3,3).'-'.substr($user['Notary']['day_phone'],6,4); ?>
			</td>
			</tr>
			<tr>
				<th><?php __('Evening Phone'); ?> </th> <td class="first_row">
				 <?php echo  substr($user['Notary']['evening_phone'],0,3).'-'.substr($user['Notary']['evening_phone'],3,3).'-'.substr($user['Notary']['evening_phone'],6,4); ?>
				</td>
			</tr>
			<tr>
				<th><?php __('Fax'); ?> </th> <td class="first_row"><?php __($counter->tousphone($user['Notary']['fax'])); ?></td>
			</tr>
			<tr>
				<th><?php __('Commision'); ?> </th> <td class="first_row"><?php echo $user['Notary']['commission'] ?></td>
			</tr>
			<tr>
				<th><?php __('Expiration'); ?> </th> <td class="first_row"><?php echo $counter->formatdate('nsdate',$user['Notary']['expiration']); ?></td>
			</tr>
			<tr>
				<th><?php __('Document Delivery Address'); ?> </th> <td class="first_row"><?php echo $user['Notary']['dd_address'].", ".$user['Notary']['dd_state'].", ".$user['Notary']['dd_city'].", ".$user['Notary']['dd_zip'] ?></td>
			</tr>
	  </table>
	</div>
</div>
