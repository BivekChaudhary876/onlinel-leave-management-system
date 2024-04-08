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
          <a href="#" class="nav-link link-body-emphasis dropdown-toggle" role="button" id="holidaysDropdown"
              data-bs-toggle="dropdown" aria-expanded="false">
              <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#calendar3"></use></svg>
              Holidays
          </a>
          <ul class="dropdown-menu text-center" aria-labelledby="holidaysDropdown">
            <li>
                <div class="my-3 text-center">
                    <button id="createHolidayBtn" class="btn btn-outline-success">Create</button>
                </div>
            </li>
          </ul>
        </li>
    </ul>
</div>


<!-- Holiday Form  -->

<div class="modal fade" id="createHolidayModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Holiday</h5>
      </div>
      <div class="modal-body">
        <!-- Form for adding a new holiday -->
        <form method="POST" action="index.php?c=dashboard&m=save">
            <input type="hidden" id="id" name="id">
          <div class="form-group">
            <label for="year">Year</label>
            <input type="text" class="form-control" id="year" name="year" placeholder="Enter year" required>
          </div>
          <div class="form-group">
            <label for="month">Month</label>
            <select class="form-control" id="month" name="month" required>
              <option value="">Select Month</option>
              <option value="1">January</option>
              <option value="2">February</option>
              <option value="3">March</option>
              <option value="4">April</option>
              <option value="5">May</option>
              <option value="6">June</option>
              <option value="7">July</option>
              <option value="8">August</option>
              <option value="9">September</option>
              <option value="10">October</option>
              <option value="11">November</option>
              <option value="12">December</option>
            </select>
          </div>
          <div class="form-group">
            <label for="days">Days</label>
            <input type="text" class="form-control" id="day" name="day" placeholder="Enter days (comma-separated)" required>
          </div>
          <div class="form-group">
            <label for="events">Events</label>
            <textarea class="form-control" id="event" name="event" rows="3" placeholder="Enter holiday events" required></textarea>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="submit" class="btn btn-success">Add Holiday</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
