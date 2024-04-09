<div class="my-3 d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="width: 280px;">
    <ul class="nav nav-pills flex-column mb-auto">
      <?php if(isset($_SESSION['current_user']['role']) && $_SESSION['current_user']['role'] == 'admin') { ?>
        <li>
            <a href="index.php?c=dashboard" class="nav-link link-body-emphasis">
                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
                Dashboard
            </a>
        </li>
        <li>
            <a href="index.php?c=user&m=list" class="nav-link link-body-emphasis">
                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#people-circle"></use></svg>
                Users
            </a>
        </li>
        <li>
          <a href="index.php?c=leave&m=list" class="nav-link link-body-emphasis">
                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#people-circle"></use></svg>
                Leave
            </a>
        </li>
        <li>
          <a href="index.php?c=holiday&m=list" class="nav-link link-body-emphasis">
                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#people-circle"></use></svg>
                Holidays
            </a>
        </li>
            <?php }else{ ?>
              <li>
                <a href="index.php?c=user&m=list" class="nav-link link-body-emphasis">
                    <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#people-circle"></use></svg>
                    Users
                </a>
            </li>
            <li>
            <a href="index.php?c=leave&m=list" class="nav-link link-body-emphasis">
                    <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#people-circle"></use></svg>
                    Leave
                </a>
            </li>
            <li>
            <a href="index.php?c=holiday&m=list" class="nav-link link-body-emphasis">
                    <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#people-circle"></use></svg>
                    Holidays
                </a>
            </li>
            <?php } ?>

    </ul>
</div>



<script>
  
  </script>