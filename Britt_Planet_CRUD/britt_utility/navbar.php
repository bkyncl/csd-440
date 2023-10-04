<!-- 
navbar.php 
Planet CRUD app
Name: Brittany Kyncl
Date: 9.23.23
Course: CSD440
Navigation bar component including navigation links, styling, and conditional display based on user login status.
-->
<?php
// Get the current page's filename for highlighting the active link
$currentPage= basename($_SERVER['PHP_SELF']);
?>
<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<nav class="navbar navbar-expand-lg fs-3 mb-5" style="background-color: black; min-height: 65px;">
    <div class="d-flex align-items-center mr-auto">
        <h5 style="padding-left: 25px;" class="m-0">PLANET C.R.U.D.</h5>
    </div>
    <?php if (isset($_SESSION['user_id'])) { ?> <!-- Check if the user is logged in -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon">
            <i class="fas fa-bars"></i> 
        </span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav mx-auto">
                <a id="link-home" class="nav-link text-white ml-auto <?= ($currentPage == 'index.php') ? 'active' : ''; ?>" href="index.php" >HOME</a>   
                <a id="link-search" class="nav-link text-white ml-auto <?= ($currentPage == 'BrittQuerySearch.php') ? 'active' : ''; ?>" href="BrittQuerySearch.php">SEARCH PLANETS</a>       
                <a id="link-insert" class="nav-link text-white ml-auto <?= ($currentPage == 'BrittForms.php') ? 'active' : ''; ?>" href="BrittForms.php">INSERT PLANETS</a>
                <a id="link-edit" class="nav-link text-white ml-auto <?= ($currentPage == 'BrittEditForms.php') ? 'active' : ''; ?>" href="BrittEditForms.php">ALL PLANETS</a>
            </div>
            <div class="d-flex align-items-center" id="logout-button">
                <a class="btn btn-success" href="?logout=true">Logout</a>
            </div>
    </div>
    <?php } ?> <!-- End of conditional display -->
</nav>
<!-- Add jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<!-- Bootstrap  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>