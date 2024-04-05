<div class="my-3 d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="width: 280px;">
  <ul class="nav nav-pills flex-column mb-auto">
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
    <li class="dropdown">
      <a href="#" class="nav-link link-body-emphasis dropdown-toggle" role="button" id="holidaysDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#calendar3"></use></svg>
        Holidays
      </a>
      <form action="?c=user&m=holidays" method="POST">
          <?php
          $currentYear = date('Y');
          $yearOptions = '';
          for ($year = $currentYear; $year <= $currentYear + 5; $year++) {
              $yearOptions .= "<option value=\"$year\">$year</option>";
          }
          $months = [
              1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June',
              7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
          ];
          $monthOptions = '';
          foreach ($months as $monthNumber => $monthName) {
              $monthOptions .= "<option value=\"$monthNumber\">$monthName</option>";
          }
          ?>
          <ul class="dropdown-menu" aria-labelledby="holidaysDropdown">
              <li>
                  <div class="dropdown-item">
                      <select id="yearSelect" name="year" class="form-select">
                          <?php echo $yearOptions; ?>
                      </select>
                  </div>
              </li>
              <li>
                  <div class="dropdown-item">
                      <select id="monthSelect" name="month" class="form-select">
                          <?php echo $monthOptions; ?>
                      </select>
                  </div>
              </li>
              <li>
                  <hr class="dropdown-divider">
              </li>
              <li>
                  <button type="submit" class="dropdown-item btn btn-primary">Show Holidays</button>
              </li>
          </ul>
      </form>
    </li>
  </ul>
</div>

<div id="holidaysContainer"></div>