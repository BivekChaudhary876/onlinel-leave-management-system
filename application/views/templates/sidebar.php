<div class="my-3 d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="width: 170px;">
    <ul class="nav nav-pills flex-column mb-auto">
      <?php if( $_SESSION[ 'current_user' ][ 'role' ] == 'admin' ) { ?>
        <li>
            <a href="dashboard" class="nav-link link-body-emphasis">
                Dashboard
            </a>
        </li>
        <li>
            <a href="user/list" class="nav-link link-body-emphasis">
                Users
            </a>
        </li>
        <li>
          <a href="type" class="nav-link link-body-emphasis">
                Leave Type
            </a>
        </li>
        <li>
          <a href="leave" class="nav-link link-body-emphasis">
                Leave
            </a>
        </li>
        <li>
          <a href="holiday" class="nav-link link-body-emphasis">
                Holidays
            </a>
        </li>
            <?php }else{ ?>
              <li>
                <a href="dashboard" class="nav-link link-body-emphasis">
                    Dashboard
                </a>
            </li>  
              <li>
                <a href="user/list/id=<?php echo $_SESSION['current_user']['id']?>" class="nav-link link-body-emphasis">
                    Profile
                </a>
            </li>
            <li>
            <a href="leave"  class="nav-link link-body-emphasis">
                    Leave
                </a>
            </li>
            <li>
            <a href="holiday" class="nav-link link-body-emphasis">
                    Holiday
                </a>
            </li>

            <!-- <li>
            <a href="setting" class="nav-link link-body-emphasis">
                    Settings
                </a>
            </li> -->
            <?php } ?>

    </ul>
</div>