<?php
    include '../../lib/db.php';

    $facName = $_POST["facultyName"];
    $cid = intval($_POST["campusId"]);
    $from = $_POST["ref"];

    if ($cid===-1){
        header( "location: /cpv/cpn/error.php?msg=Missing%20data" );
        exit(0);
    }

    $connection = initDbConnection();
    $result = mysqli_query($connection, 'INSERT INTO table_faculty (name_faculty, id_campus) VALUES ("'. $facName .'", '. $cid .');');
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