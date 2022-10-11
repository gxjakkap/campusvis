<?php
    function sidebar($currentPage){
        $indexActive = '';
        $depActive = '';
        $mdepActive = '';
        switch ($currentPage){
            case 'mdep':
                $mdepActive = 'active';
                break;
            case 'dep':
                $depActive = 'active';
                break;
            case 'index':
                $indexActive = 'active';
                break;
            default:
                break;
        }
        return '<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                    <div class="position-sticky pt-3 sidebar-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link '. $indexActive .'" href="/cpv/cpn/index.php">
                                    <span data-feather="home" class="align-text-bottom"></span>
                                    แก้ไขคณะ
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link '. $depActive .'" href="/cpv/cpn/dep.php">
                                    <span data-feather="file" class="align-text-bottom"></span>
                                    แก้ไขสาขาวิชา
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link '. $mdepActive .'" href="/cpv/cpn/mdep.php">
                                    <span data-feather="file" class="align-text-bottom"></span>
                                    แก้ไขสาขาวิชา (ปริญญาโท)
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>';
    }
?>
