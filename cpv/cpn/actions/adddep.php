<?php
    include '../../lib/db.php';

    $facid = intval($_POST["fid"]);
    $type = intval($_POST["type"]);
    $name = $_POST["depname"];
    $from = $_POST["ref"];

    if ($facid===-1||$type===-1){
        header( "location: /cpv/cpn/error.php?msg=Missing%20data" );
        exit(0);
    }

    switch ($type) {
        case 1:
            $sql = 'INSERT INTO table_department (name_department, id_faculty) VALUES ("'. $name .'", '. $facid .');';
            break;
        case 2:
            $sql = 'INSERT INTO table_department_master (name_department, id_faculty) VALUES ("'. $name .'", '. $facid .');';
            break;
        default:
            header( "location: /cpv/cpn/success.php?s=400" );
            exit(0);
            break;
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
