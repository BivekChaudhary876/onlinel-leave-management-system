
<div class="main">
    <h5 class="card-title">Leave Details</h5>
    <div class="row">
        <?php foreach ( $details as $key => $detail  ) : ?>
            <h6 class="info">Name:  <p> <?php echo esc_attr( $detail[ 'username' ] ); ?></p> </h6>
            <h6 class="info">Email: <p><?php echo esc_attr( $detail[ 'email' ] ); ?></p></h6>
            <h6 class="info">Department: <p><?php echo esc_attr( $detail[ 'department' ] ); ?></p></h6>
            <h6 class="info">Leave Type: <p><?php echo esc_attr( $detail[ 'leave_type' ] ); ?></p></h6>
            <h6 class="info">Descriptions: <p><?php echo esc_attr( $detail[ 'description' ] ); ?></p></h6>
            <h6 class="info">Status: <p><?php echo esc_attr( $detail[ 'status' ] ); ?></p></h6>
            <?php if ( $detail[ 'to_date' ]) :?>
                <h6 class="info">Leave Date: 
                    <p>
                        <?php 
                        echo esc_attr( date( 'jS M Y, l', strtotime( $detail[ 'from_date' ] ) ) ) . ' - ' . esc_attr( date( 'jS M Y, l', strtotime( $detail[ 'to_date' ] ) ) ); 
                        ?> 
                    </p>
                </h6>
            <?php else : ?>
                <h6 class="info">Date: 
                    <p>
                        <?php 
                        echo esc_attr( date( 'jS M Y, l', strtotime( $detail[ 'from_date' ] ) ) ); 
                        ?>
                    </p>
                </h6>
            <?php endif; ?>
        </h6>
    <?php endforeach;?>
</div>
</div>


