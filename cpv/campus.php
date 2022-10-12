<?php
    include 'lib/db.php';

    $id = $_GET["id"];

    if (!$id){
        header('location: error.php');
    }

    $connection = initDbConnection();
    $sql = "SELECT name_campus, name_faculty FROM table_campus LEFT JOIN table_faculty ON table_campus.id_campus=table_faculty.id_campus WHERE table_campus.id_campus=$id";
    $presult = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_assoc($presult)){
        $pcampusName[] = $row["name_campus"];
        $pfacultyName[] = $row["name_faculty"];
    }    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $pcampusName[0]?> - App</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.1/css/bootstrap.min.css" integrity="sha512-siwe/oXMhSjGCwLn+scraPOWrJxHlUgMBMZXdPe2Tnk3I0x3ESCoLz7WZ5NTH6SZrywMY+PB1cjyqJ5jAluCOg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <div class="container-fluid">
            <?php include 'components/navbar.component.php'; ?>
            <!-- <button type="button" class="btn btn-light" id="print">Light</button> -->
            <div class="py-5 my-5 text-center" id="main">
                <h1 class="display-5 fw-bold"><?php echo $pcampusName[0] ?></h1>
                <div class="col-lg-6 mx-auto">
                    <h3 class="lead mb-4">รายชื่อคณะ</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ชื่อ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if (mysqli_num_rows($presult) > 0){
                                    for ($x=0; $x<count($pfacultyName); $x++){
                                        echo '<tr>';
                                        echo '<th scope="row">'. $x+1 .'</th>';
                                        echo '<td scope="row"><a href="faculty.php?fq='. htmlentities($pfacultyName[$x]) .'">'. $pfacultyName[$x].'</a></td>';
                                        echo '</tr>';
                                    }                                    
                                }
                                else {
                                    echo '<td colspan="2">ไม่พบข้อมูล</td>';
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php mysqli_close($connection); ?>
                </div>
            </div>
            <?php include 'components/footer.component.php'; echo ft()?>
        </div>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.1/js/bootstrap.bundle.min.js" integrity="sha512-1TK4hjCY5+E9H3r5+05bEGbKGyK506WaDPfPe1s/ihwRjr6OtL43zJLzOFQ+/zciONEd+sp7LwrfOCnyukPSsg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.umd.min.js"></script> -->
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.min.js" integrity="sha512-pZmE8nx/gdufIRZ9DdgsipK4ocMbdq6zU2epbECb4/iwu9bHfN3aDYmOiVNC8SHk90uWi03o1ziB6JEd6/3VQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/rasterizehtml/1.3.1/rasterizeHTML.allinone.min.js" integrity="sha512-8oluEnt1t+gexGfDJb99W//rKC167lnwXrpJYdmYt+hUlptb6zuGORyZsTQD2+5vcNlyli8iP8V4j+IUNwNlMw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
        <script>
           /*  const pb = document.getElementById('print')
            /* 
            pb.addEventListener('click', () => {
                print(document.getElementById('main'))
            }) 
            window.jsPDF = window.jspdf.jsPDF;
            const doc = new jsPDF()
            
            const content = document.getElementById('main')

            pb.addEventListener('click', () => {
                doc.addHTML(document.body, () => {
                doc.save('file.pdf')
            })
            }) */

        </script>
    </body>
</html>