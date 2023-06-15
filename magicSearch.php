<?php

header('Content-Type: application/json');

if (isset($_GET["table"]) && isset($_GET["name"])) {
    $con = mysqli_connect("localhost", "root", "root", "zoo_matching");
    $country_results = mysqli_query($con, "SELECT name FROM " . $_GET['table'] . " WHERE name LIKE '%" . $_GET['name'] . "%' ORDER BY name");

    $country_list = array();
    while ($country = mysqli_fetch_assoc($country_results)) {
        $country_list[] = $country;
    }
    $response = array(
        "status" => array("code" => 1),
        "data" => json_encode($country_list)
    );
} else {
    $response = array(
        "status" => array(
            "code" => 0,
            "msg" => "You did not provide a Table or Name!"
        ),
        "data" => false
    );
}
echo json_encode($response);
