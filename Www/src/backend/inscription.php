<?php

include ("db_connect.php");
$db = new db_connect();
$conn = $db->connexion();

inscription($conn);

function inscription($conn) {
	$body = json_decode(file_get_contents("php://input"),true);
	if(isset($body)){
	
		$pseudo = $body['pseudo'];
		$lastname = $body['lastname'];
		$firstname = $body['firstname'];
		$age = intval($body['age']);
		$country = $body['country'];
		$city = $body['city'];
		$address = $body['address'];
		$address2 = $body['address2'];
		$phone = $body['phone'];
		$mail = $body['mail'];
		$password = $body['password'];
		
		if(!preg_match("/(?=.{8,}$)(?=.*[A-Z])/",$password)){
			printf("Message d'erreur : password incorrect" ); 
		}else {
			if (!$sql = $conn->query('INSERT INTO address (address, country, city, address2) VALUES (
				"' .$address.'", 
				"'.$country.'",  
				"'.$city.'",
				"'.$address2.'")')){
					printf("Erreur : %s\n", $conn->error);
				}
			$lastid_address = mysqli_insert_id($conn);
		
			if (!$sql = $conn->query('INSERT INTO user (pseudo, firstname, lastname, age, phone, id_address, mail, password) VALUES (
				"' .$pseudo.'", 
				"'.$firstname.'",  
				"'.strtoupper($lastname).'",
				"'.$age.'",
				"'.$phone.'",
				"'.$lastid_address.'",
				"'.$mail.'",
				"'.$password.'")')){
					printf("Erreur : %s\n", $conn->error);
				}
				
		}
	}
}
?>