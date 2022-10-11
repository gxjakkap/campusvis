<?php
    include 'lib/db.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.1/css/bootstrap.min.css" integrity="sha512-siwe/oXMhSjGCwLn+scraPOWrJxHlUgMBMZXdPe2Tnk3I0x3ESCoLz7WZ5NTH6SZrywMY+PB1cjyqJ5jAluCOg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <div class="container-fluid">
            <?php include 'components/navbar.component.php' ?>
            <?php
                $connection = initDbConnection();
                $presult = mysqli_query($connection, 'SELECT name_faculty, name_campus, table_campus.id_campus, table_faculty.name_faculty FROM table_campus LEFT JOIN table_faculty ON table_campus.id_campus=table_faculty.id_campus ORDER BY table_campus.id_campus ASC;');
                $pfaculty = [];
                while ($row = mysqli_fetch_assoc($presult)){
                    $campus[] = $row["name_campus"];
                    if (array_key_exists($row["id_campus"], $pfaculty)){
                        $pfaculty[$row["id_campus"]][] = $row["name_faculty"];
                    }
                    else {
                        $pfaculty += [$row["id_campus"] => [$row["name_faculty"]]];
                    }
                }
                $pfaculty = array_filter($pfaculty);
                $faccount = [];

                $campusName = array_unique($campus);

                foreach ($pfaculty as $key => $eachcampus) {
                    $faccount[$key] = count($eachcampus);
                }

            ?>
            <div class="px-4 py-2 my-5 text-center">
                <!-- <img class="d-block mx-auto mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
                <h1 class="display-5 fw-bold">คณะในมหาวิทยาลัยสงขลานครินทร์</h1>
                <div class="col-lg-6 mx-auto">
                    <div>
                        <canvas id="piechart" class='img-responsive'></canvas>
                    </div>
                    
                </div>
            </div>
            <?php include 'components/footer.component.php'; echo ft()?>
            <?php mysqli_close($connection); ?>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.1/js/bootstrap.bundle.min.js" integrity="sha512-1TK4hjCY5+E9H3r5+05bEGbKGyK506WaDPfPe1s/ihwRjr6OtL43zJLzOFQ+/zciONEd+sp7LwrfOCnyukPSsg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            const data = {
                labels: [<?php echo '"'.implode('", "', $campusName).'"'?>],
                datasets: [{
                    label: 'My First Dataset',
                    data: [<?php echo implode(', ', $faccount)?>],
                    backgroundColor: [
                    '#62b5f5',
                    '#1874d0',
                    '#ef6a00',
                    '#fed44e',
                    '#445862'
                    ],
                    hoverOffset: 4
                }]
            };
            const config = {
                type: 'doughnut',
                data: data,
            };
            let pchart = new Chart(document.getElementById('piechart'), config)
        </script>
    </body>
</html>