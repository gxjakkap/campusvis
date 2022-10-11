<?php
    include '../../lib/db.php';
    $type = intval($_POST["type"]);
    $from = $_POST["ref"];

    switch ($type) {
        case 1:
            $did = intval($_POST["did"]);
            $sql = 'DELETE FROM table_department WHERE id_department="'. $did .'";';
            break;
        case 2:
            $did = intval($_POST["mdid"]);
            $sql = 'DELETE FROM table_department_master WHERE id_department="'. $did .'";';
            break;
        default:
            header( "location: /cpv/cpn/error.php?msg=Unknown%20error" );
            exit(0);
            break;
    }

    if ($did===-1||$type===-1){
        header( "location: /cpv/cpn/error.php?msg=Missing%20data" );
        exit(0);
    }

    $connection = initDbConnection();
    $result = mysqli_query($connection, $sql);
    if ($result){
        echo "OK";
    }
    else {
        die("Error: " . mysqli_error($connection));
    }
    mysqli_close($connection);
    header( "location: /cpv/cpn/success.php?from=$from" );
    exit(0);
?>