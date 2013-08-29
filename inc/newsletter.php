<?php

if ($_GET["ajax"]) {
	echo newsletter();
}

function newsletter() {

	require "config.php";

	$email = $_GET["email"];

	$success = 1;
	$msg = $subscription_messages['success'];

	if (!$email) {
		$success = 0;
		$msg = $subscription_messages['email_blank'];
	}
	else if (!preg_match("/^[^\W][-a-zA-Z0-9_]+(\.[-a-zA-Z0-9_]+)*\@[-a-zA-Z0-9_]+(\.[-a-zA-Z0-9_]+)*\.[-a-zA-Z]{2,4}$/", $email)) {
		$success = 0;
		$msg = $subscription_messages['email_invalid'];
	}
	else {
		if ($newsletter_mode == 'mysql') {
			try {
				$newsletter = new PDO("mysql:host=" . $db_config["DB_HOST"] . ";dbname=" . $db_config["DB_NAME"], $db_config["DB_USERNAME"], $db_config["DB_PASSWORD"]);

				$create = $newsletter->prepare("CREATE TABLE IF NOT EXISTS `newsletter` (
					`email` varchar(32) NOT NULL
				)");
				$create->execute();

				$get = $newsletter->prepare("SELECT * FROM newsletter WHERE email = :email");
				$get->bindParam("email", $email, PDO::PARAM_STR);
				$get->execute();

				$result = $get->fetchAll();

				if ($result) {
					$success = 0;
					$msg = $subscription_messages['email_exists'];
				}
				else {
					$set = $newsletter->prepare("INSERT INTO newsletter(email) VALUES(:email)");
					$set->bindParam("email", $email, PDO::PARAM_STR);
					$set->execute();

					echo sendmail($email);
				}
			}
			catch (PDOException $e) {
				//echo "Error: " . $e->getMessage();
				$success = 0;
				$msg = "There was an error connecting to the database";
			}
		}
		else if ($newsletter_mode == 'text') {
			$emails = file_get_contents('subscribers.php');

			if (strpos($emails, $email) !== false) {
				$success = 0;
				$msg = $subscription_messages['email_exists'];
			}
			else {
				file_put_contents('subscribers.php', $email . "\r\n" , FILE_APPEND);
				echo sendmail($email);
			}
		}
		else if ($newsletter_mode == 'mailchimp') {
			require_once 'mailchimp/api.php';

			$api = new MCAPI ($mailchimp_config ['api_key']);
			$list_id = $mailchimp_config['list_id'];

			if (!$api->listSubscribe($list_id, $email) === true) {
				$success = 0;
				$msg = $api->errorMessage;
			}
		}
		else if ($newsletter_mode == 'campaignmonitor') {
			require_once 'campaignmonitor/csrest_subscribers.php';

			$wrap = new CS_REST_Subscribers($campaignmonitor_config['list_id'], $campaignmonitor_config['api_key']);
			$result = $wrap->add (array(
				'EmailAddress' => $email,
				'Resubscribe' => true
			));

			if (!$result->was_successful()) {
				$success = 0;
				$msg = 'Failed with code ' . $result->http_status_code;
			}
		}
		else {
			$success = 0;
			$msg = 'Newsletter mode is not specified, please contact the administrator';
		}
	}

	$json_data = array(
		'success' => $success, 
		'message' => $msg
	);

	return json_encode($json_data);
}

function sendmail($email) {

	require "config.php";

	$to = $admin_email;
	$subject = 'New subscriber'; // Give the email a subject   
	$message = "
	 
	You've got a new subscriber for your mailing list!

	Email: " . $email;
	                      
	$headers = 'From:' . $admin_email . '' . "\r\n"; // Set from headers  
	mail($to, $subject, $message, $headers); // Send our email  
}