<?php
	
	return [	

		'default' => 'labeler',
	    
	    'multi' => array(
	        
	        'labeler' => array(
	            'driver' => 'eloquent',
	            'model'  => App\Labeler::class,
	            'password' => [
	                'email' => 'labelers.emails.password',
	            ]
	        ),
	        
	        'user' => array(
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

