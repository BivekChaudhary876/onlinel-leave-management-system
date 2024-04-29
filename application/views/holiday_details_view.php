<div class="container mt-3">
  <div class="card w-75">
    <div class="card-body">
      <h5 class="card-title text-center">Holiday Details</h5>
      <div class="row">
        <?php foreach ( $details as $key => $detail  ) : ?>
            <h6 class="card-title d-flex gap-2">From:  <p class="fw-normal"> <?php echo $detail[ 'from_date' ]?></p> </h6>
            <h6 class="card-title d-flex gap-2">To: <p class="fw-normal"><?php echo $detail[ 'to_date' ]?></p</h6>
            <h6 class="card-title d-flex gap-2">Event: <p class="fw-normal"><?php echo $detail[ 'event' ]?></p</h6>
        </div>
        <div class="row">
            <div class="col-6">
                <h6 class="card-title">Created Date and Time: </h6>
                <p class="fw-normal"><?php echo $detail[ 'created_date' ]?></p>
            </div>
            <div class="col-6">
                <h6 class="card-title">Updated Date and Time:</h6>
                <p class="fw-normal"><?php echo $detail[ 'updated_date' ]?></p>
            </div>
        </div>
    <?php endforeach;?>
</div>
