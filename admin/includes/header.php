<nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-list-ul" style="border-color: rgb(214,53,61);color: #d6353d;"></i></button>
        <form class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group"></div>
        </form>
        <ul class="navbar-nav flex-nowrap ms-auto">


            <li class="nav-item dropdown no-arrow mx-1"></li>

            <li class="nav-item dropdown no-arrow mx-1">
                <div class="shadow dropdown-list dropdown-menu dropdown-menu-end" aria-labelledby="alertsDropdown"></div>
            </li>

            <div class="d-none d-sm-block topbar-divider"></div>

            <li class="nav-item dropdown no-arrow">
                <div class="nav-item dropdown no-arrow">

                    <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">
                        <span class="d-none d-lg-inline me-2 text-gray-600 small">Admin</span>
                        <i class="fas fa-align-justify"></i>
                    </a>

                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in">
                        <a class="dropdown-item" href="../profile.php" type="buttuon"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Settings</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Activity log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" type="button"  href="../logout.php">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400" ></i>&nbsp;Logout
                        </a>
                    </div>
                </div>
            </li>


        </ul>
    </div>
</nav>