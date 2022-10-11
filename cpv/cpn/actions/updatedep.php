<?php
    include '../../lib/db.php';
    $type = intval($_POST["type"]);
    $from = $_POST["ref"];
    $newname = $_POST["depname"];
    $newfac = intval($_POST["newfac"]);

    if (($newname==='' && $newfac===-1)){
        header( "location: /cpv/cpn/error.php?msg=Missing%20data%20or%20there%20is%20a%20data%20conflict%2E" );
        exit(0);
    }

    switch ($type) {
        case 1:
            $did = intval($_POST["did"]);
            $tablename = 'table_department';
            break;
        case 2:
            $did = intval($_POST["mdid"]);
            $tablename = 'table_department_master';
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

    if (($newname!=='' && $newfac!==-1)){
        $changes = 'name_department="'. $newname .'", id_faculty="'. $newfac .'"';
    }
    elseif ($newname!=='') {
        $changes = 'name_department="'. $newname .'"';
    }
    elseif ($newfac!==-1){
        $changes = 'id_faculty="'. $newfac .'"';
    }
    else {
        header( "location: /cpv/cpn/error.php?msg=Unknown%20error" );
        exit(0);
    }

    $sql = "UPDATE $tablename SET $changes WHERE id_department=$did";

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