<h5 class="card-title">Holiday Details</h5>
<div class="row">
  <?php foreach ( $details as $key => $detail ) : ?>
    <h6 class="info">Event: <p><?php echo esc_attr( $detail[ 'event' ] ) ?></p></h6>
    <h6 class="info">Date: <p><?php echo esc_attr( date( 'jS M Y, l', strtotime( $detail[ 'from_date' ] ) ) ); ?></p></h6>
  <?php endforeach; ?>
</div>

