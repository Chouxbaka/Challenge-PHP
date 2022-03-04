<?php 

include ("db_connect.php");
$db = new db_connect();
$conn = $db->connexion();

faq($conn);

$data = json_decode(file_get_contents('php://input'), true);

    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') { 
        deleteOne($conn, $data);
    }elseif ($_SERVER['REQUEST_METHOD'] === 'POST'){
        addNew($conn, $data);
    }

function faq($conn) {
    $response = array();
    if(isset($_GET['id'])){
            if(intval($_GET["id"])){
                $oneid = intval($_GET["id"]);
                $result = $conn->query('SELECT * FROM faq
                WHERE faq.id_faq =  "'. $oneid .'"');
            }
        }else{
            $result = $conn->query('SELECT * FROM faq ORDER BY faq.id_faq DESC');
            if (!$result) {
                printf("Erreur : %s\n", $conn->error);
            }
        }
        
    while($row = mysqli_fetch_array($result)){
        $response[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}

function addNew ($conn,$data){

    $question = $data['question'];
    $answer = $data['answer'];

        $sql = $conn->query('INSERT INTO faq (question, answer) VALUES ("' . $question . '", "' . $answer . '")');
        if (!$sql) {
            printf("Erreur : %s\n", $conn->error);
        }

}

function deleteOne($conn,$data){

    $id_faq = intval($data['id']);

    $sql = $conn->query('DELETE from faq
    WHERE id_faq = "' . $id_faq . '"');

    if (!$sql) {
        printf("Erreur : %s\n", $conn->error);
    }
}
?>