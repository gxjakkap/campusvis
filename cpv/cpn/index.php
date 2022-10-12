<?php 
    include '../lib/db.php';

    $connection = initDbConnection();
    $result = mysqli_query($connection, 'SELECT id_faculty, name_faculty, table_campus.id_campus, table_campus.name_campus 
    FROM table_faculty LEFT JOIN table_campus ON table_faculty.id_campus=table_campus.id_campus');
    $faculty = [];
    $campus = [];
    while ($row = mysqli_fetch_assoc($result)){
        if (!array_key_exists($row["id_campus"], $campus)){
            $campus[$row["id_campus"]] = $row["name_campus"];
        }
        $faculty[$row["id_faculty"]] = ["name" => $row["name_faculty"], "campusId" => $row["id_campus"], "campusName" => $row["name_campus"]];
    }
    $faculty = array_filter($faculty);
    mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>แก้ไขคณะ</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.1/css/bootstrap.min.css" integrity="sha512-siwe/oXMhSjGCwLn+scraPOWrJxHlUgMBMZXdPe2Tnk3I0x3ESCoLz7WZ5NTH6SZrywMY+PB1cjyqJ5jAluCOg==" crossorigin="anonymous" referrerpolicy="no-referrer">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css" integrity="sha512-5PV92qsds/16vyYIJo3T/As4m2d8b6oWYfoqV+vtizRB6KhF1F9kYzWzQmsO6T3z3QG2Xdhrx7FQ+5R1LiQdUA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="styles.css" rel="stylesheet">
        <style>
            .editBtn {
                background-color: #db8c07;
                color: #fff;
            }
            .deleteBtn {
                background-color: #ab2109;
                color: #fff;
            }
        </style>
    </head> 
    <body>
        <?php include 'components/header.component.html'?>
        <div class="container-fluid">
            <div class="row">
                <?php
                    include 'components/sidebar.component.php';
                    echo sidebar('index');
                ?>

                <!--Add Modal-->
                <div class="modal fade" id="addModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><b>เพิ่มคณะ</b></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="input-group">
                                    <form class="w-100" action="actions/addf.php" method="post">
                                        <select class="form-select rounded mt-3" id="campusId" name="campusId">
                                            <option selected value="-1">เลือกวิทยาเขต</option>
                                            <?php
                                                foreach ($campus as $id => $name) {
                                                    echo '<option value="'. $id .'">'. $name .'</option>';
                                                }
                                            ?>
                                        </select>
                                        <div class="flex-break"></div>
                                        <input type="text" class="form-control rounded" placeholder="ชื่อคณะ" id="addFacultyName" name="facultyName">
                                        <div class="flex-break"></div>
                                        <div class="modal-footer mt-0 mb-0">
                                            <button type="submit" class="btn btn-primary btn-md">บันทึก</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                        </div>
                                        <input class="d-none" value="index" name="ref"/>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Edit Modal-->
                <div class="modal fade" id="editModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><b>แก้ไขข้อมูลคณะ</b></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="input-group">
                                    <form class="w-100" action="actions/updatef.php" method="post">
                                        <label for="editFacultyName" class="h5">ชื่อคณะ</label>
                                        <input type="text" class="form-control rounded" placeholder="ชื่อคณะใหม่" id="editFacultyName" name="facname">
                                        <select class="form-select rounded mt-3" id="editCampusSelect" name="newcampus">
                                            <option selected value="-1">เลือกวิทยาเขตใหม่</option>
                                            <?php
                                                foreach ($campus as $id => $name) {
                                                    echo '<option value="'. $id .'" >'. $name .'</option>';
                                                }
                                            ?>
                                        </select>
                                        <div class="modal-footer mt-0 mb-0">
                                            <button type="submit" class="btn btn-primary btn-md">บันทึก</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                        </div>
                                        <input class="d-none" value="index" name="ref"/>
                                        <input class="d-none" name="facid" id="editHiddenIdBox"/>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Delete Modal-->
                <div class="modal fade" id="deleteModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><b>ลบคณะ</b></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="input-group">
                                    <p id="deleteConfirmationText"></p>
                                    <form class="w-100" action="actions/delf.php" method="post">
                                        <div class="modal-footer mt-0 mb-0">
                                            <button type="submit" class="btn btn-danger btn-md">ยืนยันการลบ</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                        </div>
                                        <input class="d-none" value="index" name="ref"/>
                                        <input class="d-none" name="fid" id="deleteHiddenIdBox"/>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <h1 class="mt-3 mb-5">แก้ไขคณะ</h1>
                    <div class="w-full position-relative">
                        <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addModal">เพิ่มคณะ</button>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">ชื่อคณะ</th>
                                    <th scope="col">วิทยาเขต</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $din = 1;
                                    foreach ($faculty as $id => $sub) {
                                        echo '<tr>';
                                            echo '<th>'. $din .'</th>';
                                            echo '<td>'. $sub["name"] .'</td>';
                                            echo '<td>'. str_replace('วิทยาเขต', '', $sub["campusName"]).'</td>';
                                            echo '<td><button class="btn editBtn mr-1" data-bs-toggle="modal" 
                                            data-bs-target="#editModal" data-bs-id="'. $id .'" data-bs-facname="'. 
                                            $sub["name"] .'" data-bs-campusname="'. $sub["campusName"] .'">แก้ไข</button>
                                            <button class="btn deleteBtn ml-1" data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                            data-bs-id="'. $id .'" data-bs-facname="'. $sub["name"] .'" data-bs-campusname="'.$sub["campusName"].'"
                                            >ลบ</button></td>';                                       
                                            echo '</tr>';
                                            $din++;
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.1/js/bootstrap.bundle.min.js" integrity="sha512-1TK4hjCY5+E9H3r5+05bEGbKGyK506WaDPfPe1s/ihwRjr6OtL43zJLzOFQ+/zciONEd+sp7LwrfOCnyukPSsg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" integrity="sha512-24XP4a9KVoIinPFUbcnjIjAjtS59PUoxQj3GNVpWc86bCqPuy3YxAcxJrxFCxXe4GHtAumCbO2Ze2bddtuxaRw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            const editModal = document.getElementById('editModal')
            editModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const id = button.getAttribute('data-bs-id')
                const name = button.getAttribute('data-bs-facname')

                console.log(id, name)
                document.getElementById('editHiddenIdBox').value = id
                document.getElementById('editFacultyName').value = name
            })

            const deleteModal = document.getElementById('deleteModal')
            deleteModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const id = button.getAttribute('data-bs-id')
                const name = button.getAttribute('data-bs-facname')
                const campusname = button.getAttribute('data-bs-campusname')

                document.getElementById('deleteHiddenIdBox').value = id
                document.getElementById('deleteConfirmationText').innerHTML = `ยืนยันที่จะลบ${name} ${campusname}?`
            })

        </script>
    </body>
</html>