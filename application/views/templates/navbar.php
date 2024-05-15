
<?php 
$logo = get_option( 'logo' );
$header_bg = get_option( 'header_bg' );
?>
<header>
  <div class="px-3 border-bottom" style="background:<?php  echo $header_bg; ?>">
    <div class="container-fluid py-2">
      <div class="row ">
        <div class="col-2 d-flex align-items-center my-2 my-lg-0 me-lg-auto">
          <a href="index.php"><img src="public/img/logo.png" alt="logo" height="50"></a>
        </div>
        <div class="col-10">
          <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
            </a>

            <ul class="nav justify-content-center">
             <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <p class="my-0 text-white fw-bold">Welcome, <?php echo $_SESSION['current_user']['username']; ?></p>
              <img src="public/img/user.png" alt="Profile" width="32" height="32" class="rounded-circle ms-2">
            </a>
            <ul class="dropdown-menu drop">
              <li>
                <a class="nav-list profile " href='user/list/<?php echo$_SESSION['current_user']['id']; ?>'><?php echo icon("user"); ?>Profile</a>
              </li>
              <li>
                <?php if ( isset( $_SESSION['current_user'])): ?>
                  <a class="nav-list logout" href="dashboard/logout"><?php echo icon("logout"); ?>Logout</a>
                <?php endif ;?>
              </li>
            </ul>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
</header>

