<div class="card-details">
    <h5 class="card-title">Leave Details</h5>
    <div class="row">
        <?php foreach ( $details as $key => $detail  ) : ?>
            <h6 class="info">Name:  <p> <?php echo $detail[ 'username' ]; ?></p> </h6>
            <h6 class="info">Email: <p><?php echo $detail[ 'email' ]; ?></p></h6>
            <h6 class="info">Department: <p><?php echo $detail[ 'department' ]; ?></p></h6>
            <h6 class="info">Leave Type: <p><?php echo $detail[ 'leave_type' ]; ?></p></h6>
            <h6 class="info">Descriptions: <p><?php echo $detail[ 'description' ]; ?></p></h6>
            <h6 class="info">Status: <p><?php echo $detail[ 'status' ]; ?></p></h6>
            <h6 class="info">Leave Date and Time: <p><?php echo $detail[ 'from_date' ]; ?></p></h6>
            <h6 class="info">Return Date and Time: <p><?php echo $detail[ 'to_date' ]; ?></p></h6>
        <?php endforeach;?>
    </div>
</div>

    
