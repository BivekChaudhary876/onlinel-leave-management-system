<header>
    <div class="px-3 py-2 text-bg-dark border-bottom">
      <div class="container">
        <div class="row">
          <div class="col-2 d-flex align-items-center my-2 my-lg-0 me-lg-auto">
            <a href="/"><img src="public/img/logo.png" alt="logo" height="50"></a>
          </div>
          <div class="col-10">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
              <a href="/" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
              </a>

              <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                <li>
                  <a href="#" class="nav-link text-white">
                    Account
                  </a>
                </li>
                <li>
                   <div class="nav-link dropdown">
                      <a href="#" class="text-decoration-none dropdown-toggle text-white" data-bs-toggle="dropdown" aria-expanded="false">
                        <strong>Welcome, 
                            <?php 
                            echo $_SESSION['current_user']['username']; ?>
                        </strong>
                        <img src="public/img/user.png" alt="" width="32" height="32" class="rounded-circle me-2">
                      </a>
                      <ul class="dropdown-menu text-small shadow">
                        <li><a class="dropdown-item" href="#">New project...</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="index.php?c=dashboard&m=logout">Sign out</a></li>
                      </ul>
                    </div>
                </li>
              </ul>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </header>




<!--- 
<div class="navssss">
    <div class="navbar">
        <li><a href="#">LMS</a></li>
    <li><li><a href="index.php?c=dashboard&m=logout">Logout</a></li></li>
    </div>
</div> -->