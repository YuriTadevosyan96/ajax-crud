<?php
include_once('../config.php');
$DB_HOST = $config["DB_HOST"];
$DB_NAME = $config["DB_NAME"];
$DB_USER = $config["DB_USER"];
$DB_PASSWORD = $config["DB_PASSWORD"];

// Create connection
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $DB_NAME";
if (!mysqli_query($conn, $sql)) {
  die("Error creating database: " . mysqli_error($conn));
} else {
    if (isset($_GET['check_connection'])) {
        echo(json_encode(true));
    }
}
// Redifine connection with DB
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

$isUserTableExistQuery = "SELECT ID FROM USERS";
$isUserTableExistResult = mysqli_query($conn, $isUserTableExistQuery);

if (empty($isUserTableExistResult)) {
    $createUserTable = "CREATE TABLE USERS(
    ID INT(11) AUTO_INCREMENT,
    NAME VARCHAR(255) NOT NULL,
    EMAIL VARCHAR(255) NOT NULL,
    PROFESSION VARCHAR(255),
    AGE INT,
    PRIMARY KEY(ID)
    )";

    $userTableCreated = mysqli_query($conn, $createUserTable);
}

// Get Users 
if (isset($_GET["get_users"])) {
    $getAllUsersQuery = "SELECT * FROM `users` WHERE 1";
    $getAllUsersResult = mysqli_query($conn, $getAllUsersQuery);
    echo(json_encode(mysqli_fetch_all($getAllUsersResult, MYSQLI_ASSOC)));
}

function xss_cleaner($input_str) {
    $return_str = str_replace( array('<',';','|','&','>',"'",'"',')','('), array('&lt;','&#58;','&#124;','&#38;','&gt;','&apos;','&#x22;','&#x29;','&#x28;'), $input_str );
    $return_str = str_ireplace( '%3Cscript', '', $return_str );
    return $return_str;
}

if ($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "PUT") {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $name = xss_cleaner($_REQUEST["name"]);
        $email = xss_cleaner($_REQUEST["email"]);
        $profession = xss_cleaner($_REQUEST["profession"]);
        $age = xss_cleaner($_REQUEST["age"]);

        $sql = "INSERT INTO `users` (`NAME`, `EMAIL`, `PROFESSION`, `AGE`)
                VALUES ('$name', '$email', NULLIF('$profession', ''), NULLIF('$age', ''))";

        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == "PUT") {
        parse_str(file_get_contents("php://input"),$put_vars);
        $name = xss_cleaner($put_vars["name"]);
        $email = xss_cleaner($put_vars["email"]);
        $profession = xss_cleaner($put_vars["profession"]);
        $age = xss_cleaner($put_vars["age"]);
        $recordId = xss_cleaner($put_vars["edit_item_id"]);
        $sql = "UPDATE `users` SET `NAME`='$name',`EMAIL`='$email',`PROFESSION`=NULLIF('$profession',''),`AGE`=NULLIF('$age','') WHERE ID=$recordId";

        if (mysqli_query($conn, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
    parse_str(file_get_contents("php://input"),$delete_vars);
    $id = $_REQUEST['id'];
    $sql = "DELETE FROM `users` WHERE ID=$id";

    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

?>