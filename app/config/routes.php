<?php
	Router::connect('/',array('controller'=>'pages', 'action'=>'display','home'));
	Router::connect('/pages/*',array('controller'=>'pages', 'action'=>'display'));
	
	/* Added by renjith Chacko for admin redirections	*/
	Router::connect('/admin',array('controller'=>'admins','action'=>'login','admin'=>'1'));
	Router::connect('/admin/logout',array('controller'=>'admins','action'=>'logout','admin'=>'1'));
	Router::connect('/admin/dashboard',array('controller'=>'admins','action'=>'dashboard','admin'=>'1'));
	Router::connect('/admin/settings',array('controller'=>'admins','action'=>'settings','admin'=>'1'));
	
	Router::connect('/admin/admins/add',array('controller'=>'admins','action'=>'add','admin'=>'1'));
	Router::connect('/admin/admins/index',array('controller'=>'admins','action'=>'index','admin'=>'1'));
	Router::connect('/admin/admins/edit',array('controller'=>'admins','action'=>'edit','admin'=>'1'));
	
	Router::connect('/admin/users/index/:type',array('controller'=>'users','action'=>'index','admin'=>'1'));
	Router::connect('/admin/users/:type/index/:page',array('controller'=>'users','action'=>'index','admin'=>'1'));
	Router::connect('/admin/users/:type/:action/:id',array('controller'=>'users','admin'=>'1'));
	Router::connect('/admin/users/:type/:action',array('controller'=>'users','action'=>'index','admin'=>'1'));
	Router::connect('/admin/users/:type/:action/:param',array('controller'=>'users','action'=>'index','admin'=>'1'));
	
	//Router::connect('/admin/messages/:action/:msgtype/*',array('controller'=>'messages','admin'=>'1'));
	Router::connect('/admin/messages/trash/index/*',array('controller'=>'messages','action'=>'index','trashed'=>'trash','admin'=>'1'));
	Router::connect('/admin/messages/sent/index/*',array('controller'=>'messages','action'=>'index','sent'=>'sent','admin'=>'1'));
	Router::connect('/admin/messages/inbox/index/*',array('controller'=>'messages','action'=>'index','admin'=>'1'));
	
	
	Router::connect('/admin/orders/top/index/*',array('controller'=>'orders','action'=>'index','top'=>'top','admin'=>'1'));
	Router::connect('/admin/orders/medium/index/*',array('controller'=>'orders','action'=>'index','medium'=>'medium','admin'=>'1'));
	Router::connect('/admin/orders/low/index/*',array('controller'=>'orders','action'=>'index','low'=>'low','admin'=>'1'));
	Router::connect('/admin/orders/all/index/*',array('controller'=>'orders','action'=>'index','admin'=>'1'));
	Router::connect('/admin/orders/add',array('controller'=>'orders','action'=>'add','admin'=>'1'));
	Router::connect('/admin/signings/archived',array('controller'=>'orders','action'=>'index','status'=>'archived','admin'=>'1'));
	Router::connect('/admin/signings/archived/:param',array('controller'=>'orders','action'=>'index','status'=>'archived','admin'=>'1'));
	Router::connect('/admin/reports/:type/:param',array('controller'=>'orders','action'=>'reports','admin'=>'1'));
	Router::connect('/admin/reports/:type',array('controller'=>'orders','action'=>'reports','admin'=>'1'));

	
	/* Added by renjith Chacko for website redirections	*/
	Router::connect('/:type/:who/signup',array('controller'=>'users','action'=>'signup'),array('pass'=>array('who')));
	Router::connect('/login',array('controller'=>'users', 'action'=>'login'));
	Router::connect('/forgotpassword',array('controller'=>'users','action'=>'forgotpassword'));
	Router::connect('/logout',array('controller'=>'users','action'=>'logout'));


	Router::connect('/news/:id-:title',array('controller'=>'news','action'=>'view'),array('pass'=>array('id'),'id'=>'[0-9]+'));
	Router::connect('/contactus',array('controller'=>'pages','action'=>'contact'));
	Router::connect('/:name',array('controller'=>'contentpages','action'=>'view'));
	
	Router::connect('/:type/myaccount',array('controller'=>'users', 'action'=>'myaccount'));
	Router::connect('/:type/myaccount/updateprofile',array('controller'=>'users','action'=>'edit'));
	Router::connect('/:type/myaccount/changepassword',array('controller'=>'users', 'action'=>'changepassword'));
	
	Router::connect('/:type/myaccount/request-a-notary',array('controller'=>'orders','action'=>'addorder'));
	Router::connect('/:type/myaccount/current-signings',array('controller'=>'orders','action'=>'index'));
	Router::connect('/:type/myaccount/archived-signings',array('controller'=>'orders','action'=>'archived'));

	Router::connect('/:type/myaccount/invoices',array('controller'=>'invoices','action'=>'index'));

	Router::connect('/:type/myaccount/assignments',array('controller'=>'assignments','action'=>'index'));
	
	Router::connect('/:type/myaccount/messages/:action/*',array('controller'=>'messages'));
	Router::connect('/:type/myaccount/tutorials',array('controller'=>'tutorials','action'=>'index'));
	Router::connect('/:type/myaccount/resources',array('controller'=>'resources','action'=>'index'));
	
	Router::connect('/professional/accountpayment',array('controller'=>'users','action'=>'accountpayment'));
	
	
	Router::connect('/notaries/:id-:name',array('controller'=>'users','action'=>'view'),array('pass'=>array('id'),'id'=>'[0-9]+'));
	
	Router::connect('/signings/fileinfo/:id-:borrower',array('controller'=>'orders','action'=>'view'),array('pass'=>array('id'),'id'=>'[0-9]+'));
	Router::connect('/signings/fileinfo/remove-doc/:id',array('controller'=>'orders','action'=>'remove_edoc'),array('pass'=>array('id'),'id'=>'[0-9]+'));
	Router::connect('/signings/fileinfo/add-docs',array('controller'=>'orders','action'=>'add_eDocs'));

	Router::connect('/signings/changestatus/:id-:borrower',array('controller'=>'signinghistories','action'=>'add'),array('pass'=>array('id'),'id'=>'[0-9]+'));
	//Router::connect('/edit/signing-requirement/:id-:borrower',array('controller'=>'orders','action'=>'edit'),array('pass'=>array('id'),'id'=>'[0-9]+'));
	Router::connect('/edit/signing/:id-:borrower',array('controller'=>'orders','action'=>'edit'),array('pass'=>array('id'),'id'=>'[0-9]+'));
	Router::connect('/signings/status-history/:id-:borrower',array('controller'=>'signinghistories','action'=>'index'),array('pass'=>array('id'),'id'=>'[0-9]+'));
	Router::connect('/signings/fileinfo/:id-:borrower/:filename',array('controller'=>'orders','action'=>'download'),array('pass'=>array('id'),'id'=>'[0-9]+'));
	