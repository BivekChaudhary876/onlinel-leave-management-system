<div class="container mt-3">
  <div class="card w-75 details">
    <div class="card-body">
      <h5 class="card-title text-center">Leave Type Details</h5>
      <div class="row">
        <?php foreach ( $details as $key => $detail  ) : ?>
            <h6 class="card-title d-flex gap-2">Name:  <p class="fw-normal"> <?php echo $detail[ 'name' ]?></p> </h6>
        <?php endforeach;?>
    </div>
</div>
