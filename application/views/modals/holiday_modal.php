<form id="create-form" method="POST" action="holiday/save">
  <input type="hidden" id="id" name="id"> 
  <div class="form-group">
    <label for="from_date">From</label>
    <input type="date" class="input" id="from_date" name="from_date"> 
  </div>
  <div class="form-group">
    <label for="to_date">To</label>
    <input type="date" class="input" id="to_date" name="to_date"> 
  </div>
  <div class="form-group">
    <label for="event">Event</label>
    <textarea class="input" id="event" name="event" rows="3" required></textarea> 
  </div>
  <div class="modal-footer">
    <button type="submit" class="button">Add/Update</button>
  </div>
</form>