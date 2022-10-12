<?php
    include 'lib/db.php';

    $query = html_entity_decode($_GET["q"]);

    $connection = initDbConnection();
    $result = mysqli_query($connection, "SELECT * FROM table_campus WHERE name_campus LIKE '%$query%'");
    while ($row = mysqli_fetch_assoc($result)){
        $campusSearched[$row["id_campus"]] = $row["name_campus"];
    }
    $result = mysqli_query($connection, "SELECT * FROM table_faculty WHERE name_faculty LIKE '%$query%'");
    while ($row = mysqli_fetch_assoc($result)){
        $facultySearched[] = $row["name_faculty"];
    }
    $result = mysqli_query($connection, "SELECT * FROM table_faculty LEFT JOIN table_department ON table_faculty.id_faculty=table_department.id_faculty WHERE name_department LIKE '%$query%'");
    while ($row = mysqli_fetch_assoc($result)){
        $depSearched[] = ["depname" => $row["name_department"], "fac" => $row["name_faculty"]];
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $query?> - App</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.1/css/bootstrap.min.css" integrity="sha512-siwe/oXMhSjGCwLn+scraPOWrJxHlUgMBMZXdPe2Tnk3I0x3ESCoLz7WZ5NTH6SZrywMY+PB1cjyqJ5jAluCOg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <div class="container-fluid">
            <?php include 'components/navbar.component.php'?>
            <div class="px-4 py-5 my-5 text-center">
                <h1 class="display-5 fw-bold">ผลการค้นหา - "<?php echo $query?>"</h1>
                <div class="col-lg-6 mx-auto">
                <?php
                    $resultsAvailable = FALSE;
                    if (!is_null(@$campusSearched)){
                        $resultsAvailable = TRUE;
                        echo '<table class="table">
                        <thead>
                            <tr>
                                <th scope="col">วิทยาเขต</th>
                            </tr>
                        </thead>
                        <tbody>';
                        foreach ($campusSearched as $key => $name) {
                            echo '<tr>';
                            echo '<td scope="row"><a href="campus.php?id='. $key .'">'. $name .'</a></td>';
                            echo '</tr>';
                        }
                        echo '</tbody>
                            </table>';
                    }
                    if (!is_null(@$facultySearched)){
                        $resultsAvailable = TRUE;
                        echo '<table class="table">
                        <thead>
                            <tr>
                                <th scope="col">คณะ</th>
                            </tr>
                        </thead>
                        <tbody>';
                        foreach ($facultySearched as $key => $name) {
                            echo '<tr>';
                            echo '<td scope="row"><a href="faculty.php?fq='.$name.'">'. $name .'</a></td>';
                            echo '</tr>';
                        }
                        echo '</tbody>
                            </table>';
                    }
                    if (!is_null(@$depSearched)){
                        $resultsAvailable = TRUE;
                        echo '<table class="table">
                        <thead>
                            <tr>
                                <th scope="col">สาขาวิชา</th>
                            </tr>
                        </thead>
                        <tbody>';
                        foreach ($depSearched as $key => $sub) {
                            echo '<tr>';
                            echo '<td scope="row"><a href="faculty.php?fq='.$sub["fac"].'">'. $sub["depname"].' ('. $sub["fac"] .')</a></td>';
                            echo '</tr>';
                        }
                        echo '</tbody>
                            </table>';
                    }
                    if (!$resultsAvailable){
                        echo '<p class="mt-3">ไม่พบผลการค้นหา</p>';
                    }
                ?>
                    <?php mysqli_close($connection); ?>
                </div>
            </div>
        </div>
        <?php include 'components/footer.component.php'; echo ft()?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.1/js/bootstrap.bundle.min.js" integrity="sha512-1TK4hjCY5+E9H3r5+05bEGbKGyK506WaDPfPe1s/ihwRjr6OtL43zJLzOFQ+/zciONEd+sp7LwrfOCnyukPSsg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </body>
</html>