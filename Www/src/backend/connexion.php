<?php

include ("db_connect.php");
$db = new db_connect();
$conn = $db->connexion();

connexion($conn);

function connexion ($conn) {
    $body = json_decode(file_get_contents("php://input"),true);
    if(isset($body)){ 
    
        $mail = $body['email'];
        $pass = $body['password'];
    
        if($sql = $conn->query('SELECT pseudo FROM user WHERE mail = "' .$mail.  '" AND password = "' .$pass. '"')){
            while($row = mysqli_fetch_array($sql))
            {
                $response[] = $row;
            }
            header('Content-Type: application/json');
            echo ($response[0]['pseudo']);
        }
    }
}
?>