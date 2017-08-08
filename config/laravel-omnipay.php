<?php

return [

	// The default gateway to use
	'default' => 'paypal',

	// Add in each gateway here
	'gateways' => [
		'alipay' => [
				'driver'  => 'Alipay_Express',
				'options' => [
					'partner' => 'your pid here',
	                'key' => 'your appid here',
	                'sellerEmail' =>'account@livesong.cn',
	                'returnUrl' => 'your returnUrl here',
	                'notifyUrl' => 'your notifyUrl here'
				]
		],
		'paypal' => [
			'driver'  => 'PayPal_Express',
			'options' => [
				'solutionType'   => '',
				'landingPage'    => '',
				'headerImageUrl' => ''
			]
		]
	]

];