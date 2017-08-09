<div>
	<h3><?php __($news['News']['title']); ?></h3>
	<?php __($html->image(($news['News']['image'] != '' and file_exists(Configure::read('NEWS_THUMB_IMAGE_PATH').$news['News']['image'])) ? '/'.Configure::read('NEWS_THUMB_IMAGE_PATH').$news['News']['image'] : 'avatar.jpg', array('class'=>'fleft','alt'=>$news['News']['title'],'title'=>$news['News']['title'])));?>
	<p><?php __($news['News']['description']); ?></p>
</div>
