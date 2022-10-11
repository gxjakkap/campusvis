<?php
    include '../../lib/db.php';

    $facId = intval($_POST["fid"]);
    $from = $_POST["ref"];

    if ($facId===-1 || !$facId){
        header( "location: /cpv/cpn/error.php?msg=Missing%20data" );
        exit(0);
    }

    $connection = initDbConnection();
    $result = mysqli_query($connection, "DELETE FROM table_faculty WHERE id_faculty=$facId");
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