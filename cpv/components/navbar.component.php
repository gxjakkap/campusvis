<!--Navbar-->
<?php
    //include '../lib/db.php';
    $connection = initDbConnection();
    $sql = "SELECT table_campus.id_campus, name_campus, name_faculty, id_faculty 
    FROM table_campus LEFT JOIN table_faculty ON table_campus.id_campus=table_faculty.id_campus 
    ORDER BY `table_campus`.`id_campus`;";
    $result = mysqli_query($connection, $sql);
    echo '<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
    <a class="navbar-brand" href="#">App</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="/cpv">Home</a>
                </li>';
                    $faculty = [];
                    while ($row = mysqli_fetch_assoc($result)){
                        $campus[] = $row["name_campus"];
                        $campusId[] = $row["id_campus"];
                        if (array_key_exists($row["id_campus"], $faculty)){
                            $faculty[$row["id_campus"]][] = $row["name_faculty"];
                        }
                        else {
                            $faculty += [$row["id_campus"] => [$row["name_faculty"]]];
                        }
                        
                    }
                    $campus = array_values(array_unique($campus));
                    $campusId = array_values(array_unique($campusId));
                    if (mysqli_num_rows($result) > 0){
                        for($x=0; $x<=count($campus); $x++){
                            echo '<li class="nav-item dropdown">';
                            if (!(is_null(@$campus[$x])) && !is_null(@$campusId[$x])){
                                if (! (is_null(@$faculty[$campusId[$x]]))){
                                    echo '<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">'. $campus[$x].'</a>
                                    <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="campus.php?id='. $campusId[$x] .'">????????????????????????'.$campus[$x].'</a></li>';
                                    for ($i=0; $i<count($faculty[$campusId[$x]]); $i++){
                                        echo '<li><a class="dropdown-item" href="faculty.php?fq='. htmlentities($faculty[$campusId[$x]][$i]) .'">'. $faculty[$campusId[$x]][$i] .'</a></li>';
                                    }
                                    echo '</ul>';
                                }
                                else {
                                    echo '<a class="nav-link active" href="campus.php?id='. $campusId[$x] .'">'. $campus[$x]  .'</a>';
                                }
                            }                            
                            echo '</li>';
                        }
                    }
            echo '</ul>
            <form class="d-flex" role="search" action="/cpv/search.php" method="GET">
                <input class="form-control me-2" type="search" placeholder="Search" name="q" aria-label="Search" required>
                <button class="btn btn-outline-success" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
              </svg></button>
            </form>
            <div class="d-flex">
                    <a class="btn" href="cpn/">?????????????????????????????????</a>
            </div>
        </div>
    </div>
</nav>';
?>
