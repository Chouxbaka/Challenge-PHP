<?php

include ("db_connect.php");
$db = new db_connect();
$conn = $db->connexion();

printProduct($conn);

$data = json_decode(file_get_contents('php://input'), true);

    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') { 
        deleteOne($conn, $data);
    }elseif ($_SERVER['REQUEST_METHOD'] === 'POST'){
        addNew($conn, $data);
    }

function printProduct($conn) {
    $response = array();
    if(isset($_GET['id'])){
        if (($_GET["id"] == "unisex") || ($_GET["id"] == "femme") || ($_GET["id"] =="homme")){
            $cat = ($_GET["id"]);
            $result = $conn->query('SELECT product.id_product, product.name, product.price, photo.url FROM product
                INNER JOIN productphoto ON product.id_product = productphoto.id_product
                INNER JOIN photo ON productphoto.id_photo = photo.id_photo
                WHERE product.category = "' . $cat . '"
                GROUP BY product.id_product');

            }else if(intval($_GET["id"])){
                $oneid = intval($_GET["id"]);
                $result = $conn->query('SELECT product.id_product, product.name, product.price, photo.url FROM product
                INNER JOIN productphoto ON product.id_product = productphoto.id_product
                INNER JOIN photo ON productphoto.id_photo = photo.id_photo
                WHERE product.id_product =  "'. $oneid .'"');
            }
            if (!$result) {
                printf("Erreur : %s\n", $conn->error);
            }
        }else{
            $result = $conn->query("SELECT product.id_product, product.name, product.price, photo.url FROM product
            INNER JOIN productphoto ON product.id_product = productphoto.id_product
            INNER JOIN photo ON productphoto.id_photo = photo.id_photo
            GROUP BY product.id_product");
            if (!$result) {
                printf("Erreur : %s\n", $conn->error);
            }
        }while($row = mysqli_fetch_array($result)){
            $response[] = $row;
        }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}

function addNew ($conn,$data){

    $name = $data['name'];
    $category = $data['category'];
    $price = intval($data['price']);
    $weight = $data['weight'];
    $url = $data['url'];
    
        $sql = $conn->query('INSERT INTO photo (url) VALUES ("' . $url . '")');
        if (!$sql) {
            printf("Erreur : %s\n", $conn->error);
        }
        $lastid_photo = mysqli_insert_id($conn);
    
        $sql = $conn->query('INSERT INTO product(name, category, price , weight) 
        VALUES ("' . $name . '","' . $category . '", "' . $price . '", "' . $weight. '")');
            if (!$sql) {
                printf("Erreur : %s\n", $conn->error);
            }
            $lastid_product = mysqli_insert_id($conn);
    
        $sql = $conn->query("INSERT INTO productphoto (id_product, id_photo) VALUES ('". $lastid_product."', '" .$lastid_photo."')");
        if (!$sql) {
            printf("Erreur : %s\n", $conn->error);
        }
}

function deleteOne($conn,$data){
    $id_product = intval($data['id_product']);

    $sql = $conn->query('DELETE product.*, productphoto.*, photo.* from product
    INNER JOIN productphoto ON product.id_product = productphoto.id_product
    INNER JOIN photo ON productphoto.id_photo = photo.id_photo
    WHERE product.id_product = "' . $id_product . '"');

    if (!$sql) {
        printf("Erreur : %s\n", $conn->error);
    }
}
?>