<div class="container mt-3">
  <div class="card w-75 details">
    <div class="card-body">
      <h5 class="card-title text-center">Leave Details</h5>
      <div class="row">
        <?php foreach ( $details as $key => $detail  ) : ?>
            <h6 class="card-title d-flex gap-2">Name:  <p class="fw-normal"> <?php echo $detail[ 'username' ]?></p> </h6>
            <h6 class="card-title d-flex gap-2">Email: <p class="fw-normal"><?php echo $detail[ 'email' ]?></p></h6>
            <h6 class="card-title d-flex gap-2">Department: <p class="fw-normal"><?php echo $detail[ 'department' ]?></p></h6>
            <h6 class="card-title d-flex gap-2">Leave Type: <p class="fw-normal"><?php echo $detail[ 'leave_type' ]?></p></h6>
            <h6 class="card-title d-flex gap-2">Descriptions: <p class="fw-normal"><?php echo $detail[ 'description' ]?></p></h6>
            <h6 class="card-title d-flex gap-2 text-capitalize">Status: <?php echo get_status_badge( $detail[ 'status' ] )?></h6>
            <div class="row">
                
                <div class="col-6">
                    <h6 class="card-title">Leave Date and Time: </h6>
                    <p class="fw-normal"><?php echo $detail[ 'from_date' ]?></p>>
                </div>
                <div class="col-6">
                    <h6 class="card-title">Return Date and Time:</h6>
                    <p class="fw-normal"><?php echo $detail[ 'to_date' ]?></p>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>
