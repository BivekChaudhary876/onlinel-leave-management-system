<div class="card-details">
  <h5 class="card-title">Holiday Details</h5>
  <div class="row">
    <?php foreach ( $details as $key => $detail  ) : ?>
      <h6 class="info">From:  <p> <?php echo $detail[ 'from_date' ]?></p></h6>
      <h6 class="info">To: <p><?php echo $detail[ 'to_date' ]?></p></h6>
      <h6 class="info">Event: <p><?php echo $detail[ 'event' ]?></p></h6>
    <?php endforeach;?>
  </div>
</div>
