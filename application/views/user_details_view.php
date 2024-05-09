
<div class="card-details">
  <h5 class="card-title">User Details</h5>
  <div class="row">
    <?php foreach ( $users as $key => $user  ) : ?>
      <h6 class="info">Name:  <p> <?php echo $user[ 'username' ]?></p> </h6>
      <h6 class="info">Email: <p><?php echo $user[ 'email' ]?></p></h6>
      <h6 class="info">Gender: <p><?php echo $user[ 'gender' ]?></p></h6>
      <h6 class="info">Birth Date: <p><?php echo $user[ 'birth_date' ]?></p></h6>
      <h6 class="info">Department: <p><?php echo $user[ 'department' ]?></p></h6>
    <?php endforeach;?>
  </div>
</div>
