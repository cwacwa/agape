<?php
	$to = "jeremy@agence-cwa.com";

	if($_POST["nom"] != "" && $_POST["email"] != "" && $_POST["message"] != ""){

		$nom = htmlspecialchars($_POST["nom"]);
		$email = htmlspecialchars($_POST["email"]);
		$message = htmlspecialchars($_POST["message"]);
		$message = str_replace("\n.", "\n..", $message);

		$subject = 'Nouveau message de : '.$nom  ;
		
		$headers = 'From: '. $email;
		mail($to, $subject, $message, $headers);
		
		echo "true";
		
	} else {

		echo "false";
		
	}
?>