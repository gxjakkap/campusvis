<?php
    include '../../lib/db.php';
    $facid = intval($_POST["facid"]);
    $newname = $_POST["facname"];
    $newcampus = intval($_POST["newcampus"]);

    $from = $_POST["ref"];

    if (($newname==='' && $newcampus===-1)||(intval($_POST["facid"])===-1)||!$newname||!$newcampus  ){
        header( "location: /cpv/cpn/error.php?msg=Missing%20data%20or%20there%20is%20a%20data%20conflict%2E" );
        exit(0);
    }

    if (($newname!=='' && $newcampus!==-1)){
        $changes = 'name_faculty="'. $newname .'", id_campus="'. $newcampus .'"';
    }
    elseif ($newname!=='') {
        $changes = 'name_faculty="'. $newname .'"';
    }
    elseif ($newcampus!==-1){
        $changes = 'id_campus="'. $newcampus .'"';
    }
    else {
        header( "location: /cpv/cpn/error.php?msg=Unknown%20error" );
        exit(0);
    }

    $sql = "UPDATE table_faculty SET $changes WHERE id_faculty=$facid";

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