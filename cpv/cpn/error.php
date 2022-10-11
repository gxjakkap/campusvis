<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Success</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.1/css/bootstrap.min.css" integrity="sha512-siwe/oXMhSjGCwLn+scraPOWrJxHlUgMBMZXdPe2Tnk3I0x3ESCoLz7WZ5NTH6SZrywMY+PB1cjyqJ5jAluCOg==" crossorigin="anonymous" referrerpolicy="no-referrer">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css" integrity="sha512-5PV92qsds/16vyYIJo3T/As4m2d8b6oWYfoqV+vtizRB6KhF1F9kYzWzQmsO6T3z3QG2Xdhrx7FQ+5R1LiQdUA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="styles.css" rel="stylesheet">
    </head> 
    <body>
        <?php include 'components/header.component.html'?>
        <div class="container-fluid">
            <div class="row">
                <?php
                    include 'components/sidebar.component.php';
                    echo sidebar('');
                ?>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="my-5 m-auto text-center">
                        <i class="bi bi-x-circle" style="font-size: 8rem; color: #fe0000;"></i>
                        <h2 class="mb-4">Error: <?php echo html_entity_decode($_GET["msg"])?></h2>
                        <button class="btn btn-primary" onClick="back()">กลับไปแก้ไขข้อมูล</a>
                    </div>
                </main>
            </div>
        </div>
        <script>
            const back = () => {
                history.back()
            }
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.1/js/bootstrap.bundle.min.js" integrity="sha512-1TK4hjCY5+E9H3r5+05bEGbKGyK506WaDPfPe1s/ihwRjr6OtL43zJLzOFQ+/zciONEd+sp7LwrfOCnyukPSsg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" integrity="sha512-24XP4a9KVoIinPFUbcnjIjAjtS59PUoxQj3GNVpWc86bCqPuy3YxAcxJrxFCxXe4GHtAumCbO2Ze2bddtuxaRw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </body>
</html>