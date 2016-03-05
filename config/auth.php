<?php
	
	return [

		'multi' => array(
			
			'user' => array(
				'driver' => 'eloquent',
				'model' => 'App\User',
				'table' => 'users',
			),

			'labeler' => array(
				'driver' => 'database',
				'model' => 'App\Labeler',
				'table' => 'labelers',
			)
		),

		'password' => [
			'email' => 'emails.password',
			'table' => 'password_resets',
			'expire' => 60,
		],
	];

