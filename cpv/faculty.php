<?php
    include 'lib/db.php';

    $fq = html_entity_decode($_GET["fq"]);

    $connection = initDbConnection();
    $presult = mysqli_query($connection, 'SELECT name_faculty, name_department FROM table_faculty LEFT JOIN table_department ON table_faculty.id_faculty=table_department.id_faculty WHERE table_faculty.name_faculty="'. $fq .'"');
    while ($row = mysqli_fetch_assoc($presult)){
        $depName[] = $row["name_department"];
        $facultyName[] = $row["name_faculty"];
    }
    $msresult = mysqli_query($connection, 'SELECT name_faculty, name_department FROM table_faculty LEFT JOIN table_department_master ON table_faculty.id_faculty=table_department_master.id_faculty WHERE table_faculty.name_faculty="'. $fq .'"');
    while ($row = mysqli_fetch_assoc($msresult)){
        $msdepName[] = $row["name_department"];
    }

    $depName = array_filter($depName);
    $msdepName = array_filter($msdepName);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $facultyName[0]?> - App</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.1/css/bootstrap.min.css" integrity="sha512-siwe/oXMhSjGCwLn+scraPOWrJxHlUgMBMZXdPe2Tnk3I0x3ESCoLz7WZ5NTH6SZrywMY+PB1cjyqJ5jAluCOg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <div class="container-fluid">
            <?php include 'components/navbar.component.php'?>
            <div class="px-4 py-5 my-5 text-center">
                <h1 class="display-5 fw-bold"><?php echo $facultyName[0] ?></h1>
                <div class="col-lg-6 mx-auto">
                    <h3 class="lead mb-4">รายชื่อสาขาวิชาที่เปิดสอน</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ระดับปริญญาตรี</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if (count($depName) > 0){
                                    for ($x=0; $x<count($depName); $x++){
                                        echo '<tr>';
                                        echo '<th scope="row">'. $x+1 .'</th>';
                                        echo '<td scope="row">'. $depName[$x].'</td>';
                                        echo '</tr>';
                                    }                                    
                                }
                                else {
                                    echo '<td colspan="2">ไม่พบข้อมูล</td>';
                                }
                            ?>
                        </tbody>
                    </table>
                    <div class="mt-5">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">ระดับมหาบัณฑิต (ปริญญาโท)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if (count($msdepName) > 0){
                                        for ($x=0; $x<count($msdepName); $x++){
                                            echo '<tr>';
                                            echo '<th scope="row">'. $x+1 .'</th>';
                                            echo '<td scope="row">'. $msdepName[$x].'</td>';
                                            echo '</tr>';
                                        }                                    
                                    }
                                    else {
                                        echo '<td colspan="2">ไม่พบข้อมูล</td>';
                                    }
                                ?>
                            </tbody>
                        </table>
                        <!-- <pre>
                            <php
                                print_r($msdepName);
                            ?>
                        </pre> -->
                    </div>
                    <?php mysqli_close($connection); ?>
                </div>
            </div>
        </div>
        <?php include 'components/footer.component.php'; echo ft()?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.1/js/bootstrap.bundle.min.js" integrity="sha512-1TK4hjCY5+E9H3r5+05bEGbKGyK506WaDPfPe1s/ihwRjr6OtL43zJLzOFQ+/zciONEd+sp7LwrfOCnyukPSsg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </body>
</html>