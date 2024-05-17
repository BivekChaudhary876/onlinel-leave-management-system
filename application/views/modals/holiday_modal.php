<form id="create-form" method="POST" action="holiday/save">
  <div class="form-content">
    <input type="hidden" id="id" name="id"> 
    <label for="from_date">From</label>
    <input type="date" class="input" id="from_date" name="from_date"> 
    <label for="event">Event</label>
    <textarea class="input" id="event" name="event" rows="3" required></textarea> 
    <button type="submit" class="button">Add/Update</button>
  </div>
</form>