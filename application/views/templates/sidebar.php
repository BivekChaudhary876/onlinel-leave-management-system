<div class="my-3 d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="width: 170px;">
    <ul class="nav nav-pills flex-column mb-auto">
      <?php if( $_SESSION[ 'current_user' ][ 'role' ] == 'admin' ) { ?>
        <li>
            <a href="index.php?c=dashboard" class="nav-link link-body-emphasis">
                Dashboard
            </a>
        </li>
        <li>
            <a href="index.php?c=user&m=list" class="nav-link link-body-emphasis">
                Users
            </a>
        </li>
        <li>
          <a href="index.php?c=leave&m=list" class="nav-link link-body-emphasis">
                Leave
            </a>
        </li>
        <li>
          <a href="index.php?c=holiday&m=list" class="nav-link link-body-emphasis">
                Holidays
            </a>
        </li>
            <?php }else{ ?>
              <li>
                <a href="index.php?c=user&m=list&id=<?php echo $_SESSION['current_user']['id']?>" class="nav-link link-body-emphasis">
                    Profile
                </a>
            </li>
            <li>
            <a href="index.php?c=leave&m=list&id=<?php echo $_SESSION[ 'current_user' ][ 'id' ] ?>"  class="nav-link link-body-emphasis">
                    Leave
                </a>
            </li>
            <li>
            <a href="index.php?c=holiday&m=list" class="nav-link link-body-emphasis">
                    Holidays
                </a>
            </li>
            <?php } ?>

    </ul>
</div>