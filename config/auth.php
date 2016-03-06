<?php
	
	return [	

		'default' => 'admin',
	    
	    'multi' => array(
	        
	        'labeler' => array(
	            'driver' => 'eloquent',
	            'model'  => App\Labeler::class,
	            'password' => [
	                'email' => 'labelers.emails.password',
	            ]
	        ),
	        
	        'admin' => array(
	            'driver' => 'eloquent',
	            'model'  => App\User::class,
	            'password' => [
	                'email' => 'users.emails.password',
	            ]
	        )
	    ),

		'password' => [
			'email' => 'emails.password',
			'table' => 'password_reminders',
			'expire' => 60,
		],
		
	];

