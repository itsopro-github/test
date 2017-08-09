<h2>News and Events</h2>
<div class="news">
	<div class="news2">
<?php
if($webnews) {
	foreach ($webnews as $webnew) {
?>		
		<p><strong><?php __($html->link($webnew['News']['title'],array('controller'=>'news', 'action'=>'view', 'title'=>Inflector::slug($webnew['News']['title']),'id'=>$webnew['News']['id']), array('escape'=>false))); ?></strong></p>
		<div class="fleft"><?php __($html->link($html->image(($webnew['News']['image'] != '' and file_exists(Configure::read('NEWS_THUMB_IMAGE_PATH').$webnew['News']['image'])) ? '/'.Configure::read('NEWS_THUMB_IMAGE_PATH').$webnew['News']['image'] : 'avatar.jpg', array('alt'=>$webnew['News']['title'],'title'=>$webnew['News']['title'])), array('controller'=>'news', 'action'=>'view', 'title'=>Inflector::slug($webnew['News']['title']),'id'=>$webnew['News']['id']), array('escape'=>false))); ?></div>
		<div>
		<p><?php __(substr($webnew['News']['description'], 0, 100)); ?>...</p></div>
		<div class="bg"><!-- no text --></div>
<?php
	}
} else {
	__($this->element('nobox',array('displaytext'=>'No news for now')));
}
?>		
	</div>
</div>