<?php

/*-----------------------------------------------------------------------------------*/
/*	1. Mode
/*	
/*	Newsletter mode. Can be set to 'text', 'mysql', 'mailchimp', 'campaignmonitor'. With 'text' selected, emails will be stored in 'inc/subscribers'.
/*	The latter two require additional configuration (see below), but are easier to maintain.
/*	Leave blank to hide the block.
/*-----------------------------------------------------------------------------------*/

$newsletter_mode = 'text';


/*-----------------------------------------------------------------------------------*/
/*	2. Administrator email
/*	
/*	Insert you email below if you wish to recieve notifications about new subscribers. If not, just leave it blank
/*-----------------------------------------------------------------------------------*/

$admin_email = '';


/*-----------------------------------------------------------------------------------*/
/*	3. Database
/*	
/*	This is only required if you have enabled the 'mysql' newletter mode
/*-----------------------------------------------------------------------------------*/

$db_config = array(
	"DB_HOST"			=> "localhost", // Database hostname (99% of time it's 'localhost')
	"DB_NAME"			=> "database", // Database name
	"DB_USERNAME"	=> "username", // Database username (DO NOT USE "root")
	"DB_PASSWORD"	=> "password" // Database password
);


/*-----------------------------------------------------------------------------------*/
/*	4. MailChimp and Campaign Monitor
/*-----------------------------------------------------------------------------------*/

//	This is only required if you have enabled the 'mailchimp' newletter mode. Please refer to the documentation for intructions on how to get your api key and list id
$mailchimp_config = array(
	'api_key'	=> 'MailChimp API key',
	'list_id'		=> 'MailChimp list ID'
);

//	This is only required you have enabled the 'campaignmonitor' newletter mode. Please refer to the documentation for intructions on how to get your api key and list id
$campaignmonitor_config = array(
	'api_key'	=> 'Campaign Monitor API key',
	'list_id'		=> 'Campaign Monitor list ID'
);


/*-----------------------------------------------------------------------------------*/
/*	5. Translation
/*	
/*	Translate messages that appear in the subscribing process
/*-----------------------------------------------------------------------------------*/

$subscription_messages = array(
	'success' 		=> "Thank you! We'll keep in touch!",
	'email_blank'	=> "Please provide an email address",
	'email_invalid'	=> "Invalid email address",
	'email_exists'	=> "You are already subscribed to our newsletter!"
);