<?php

require_once "vendor/autoload.php";

$conn = mysqli_connect("localhost", "root", "", "ecommerce");

$faker = Faker\Factory::create();

$name = array(
    "hoodie01" => "unisex",
    "hoodie02" => "femme",
    "hoodie03" => "unisex",
    "hoodie04" => "unisex",
    "jean01" => "femme",
    "jean02" => "femme",
    "jean03" => "femme",
    "jean04" => "femme",
    "l'elegant" => "homme",
    "tshirt01" => "homme",
    "tshirt02" => "unisex",
    "tshirt03" => "unisex",
    "tshirt04" => "unisex", 
    "classique" => "homme",
);
$weight = array(
    "XS","S","M","L","XL","XXL"
);

for ($i = 0; $i < 100; $i++) {
    $rdm = rand(0,13);

    /* $sql = 'INSERT INTO adress (id_address, street, country, postal_code, city, floor) VALUES ("' . $faker->streetName() . '", "' . $faker->country() . '", "'. $faker->state() . '", "' . $faker->postcode() . '", "' . $faker->city() . '")';
    mysqli_query($conn, $sql,);  */

    $sql = 'INSERT INTO photo (url) VALUES ("' . array_keys($name)[$rdm] . '.png")';
    mysqli_query($conn, $sql);
    $lastid_photo = mysqli_insert_id($conn);

    $sql = 'INSERT INTO product(name, category, price , weight) 
    VALUES ("' . (array_keys($name)[$rdm]) . '","' . $name[array_keys($name)[$rdm]] . '", "' . rand(1, 300). '", "' . $weight[rand(0, 5)]. '")';
    
    mysqli_query($conn, $sql);
    if (!mysqli_query($conn,$sql)) {
        printf("Message d'erreur : %s\n", mysqli_error($conn));
    }
    $lastid_product = mysqli_insert_id($conn);

    $sql = "INSERT INTO commandline (id_product, quantity) VALUES ('" . rand(1, 100) . "', '" . rand(1, 100) . "')";
    mysqli_query($conn, $sql);

    /* $sql = "INSERT INTO user (id_user, pseudo, first_name, last_name, age, mail, phone, id_address, password) 
    VALUES ('" . rand(1, 100) . "', '" . $faker->firstName() . "', '" . $faker->firstName() . "', '" . rand(1, 100) . "', '" . $faker->firstName() . "', '" . $faker->email() . "',  '" . $faker->phoneNumber() . "', '" . rand(1, 100) . "', '" . rand(1, 100) . "', '" . $faker->firstName() . "')";
    if (!mysqli_query($conn,$sql)) {
        printf("Message d'erreur : %s\n", mysqli_error($conn));
    }
    mysqli_query($conn, $sql); */


    $sql = "INSERT INTO productphoto (id_product, id_photo) VALUES ('". $lastid_product."', '" .$lastid_photo."')";
    mysqli_query($conn, $sql);
    // printf($lastid_product);
    // echo "||";
    // printf($lastid_photo);


  /*   $sql = "INSERT INTO command (id_user, command_date) VALUES ('" . rand(1, 100) . "', '" . date('Y-m-d') . "')";
    mysqli_query($conn, $sql);
 */

   /*  $sql = "INSERT INTO cart (id_command_line, id_user) VALUES ('" . rand(1, 100) . "', '" . rand(1, 100) . "')";
    mysqli_query($conn, $sql); */

/* 
    $sql = "INSERT INTO userphoto (id_user, id_photo) VALUES ('" . rand(1, 100) . "', '" . rand(1, 100) . "')";
    mysqli_query($conn, $sql); */
}
?>