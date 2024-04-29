<div class="container mt-3">
  <div class="card w-75">
    <div class="card-body">
      <h5 class="card-title text-center">User Details</h5>
      <div class="row">
        <?php foreach ( $users as $key => $user  ) : ?>
            <h6 class="card-title d-flex gap-2">Name:  <p class="fw-normal"> <?php echo $user[ 'username' ]?></p> </h6>
            <h6 class="card-title d-flex gap-2">Email: <p class="fw-normal"><?php echo $user[ 'email' ]?></p</h6>
            <h6 class="card-title d-flex gap-2">Department: <p class="fw-normal"><?php echo $user[ 'department' ]?></p</h6>
        </div>
        <div class="row">
            <div class="col-6">
                <h6 class="card-title">Created Date and Time: </h6>
                <p class="fw-normal"><?php echo $user[ 'created_date' ]?></p>
            </div>
            <div class="col-6">
                <h6 class="card-title">Updated Date and Time:</h6>
                <p class="fw-normal"><?php echo $user[ 'updated_date' ]?></p>
            </div>
        </div>
    <?php endforeach;?>
</div>
