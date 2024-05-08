<div class="container mt-3">
  <div class="card w-75 details">
    <div class="card-body">
      <h5 class="card-title text-center">User Details</h5>
      <div class="row">
        <?php foreach ( $users as $key => $user  ) : ?>
            <h6 class="card-title d-flex gap-2">Name:  <p class="fw-normal"> <?php echo $user[ 'username' ]?></p> </h6>
            <h6 class="card-title d-flex gap-2">Email: <p class="fw-normal"><?php echo $user[ 'email' ]?></p></h6>
            <h6 class="card-title d-flex gap-2">Gender: <p class="fw-normal"><?php echo $user[ 'gender' ]?></p></h6>
            <h6 class="card-title d-flex gap-2">Birth Date: <p class="fw-normal"><?php echo $user[ 'birth_date' ]?></p></h6>
            <h6 class="card-title d-flex gap-2">Department: <p class="fw-normal"><?php echo $user[ 'department' ]?></p></h6>
        </div>
    <?php endforeach;?>
</div>
