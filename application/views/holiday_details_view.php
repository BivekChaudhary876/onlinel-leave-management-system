<div class="card-details">
  <h5 class="card-title">Holiday Details</h5>
  <div class="row">
    <?php foreach ( $details as $key => $detail ) : ?>
      <h6 class="info">Event: <p><?php echo esc_attr( $detail[ 'event' ] ) ?></p></h6>
      <?php if ($detail['to_date']) : ?>
        <h6 class="info">Date: <p><?php echo esc_attr( date( 'jS M Y, l', strtotime( $detail[ 'from_date' ] ) ) ) . ' - ' . esc_attr( date( 'jS M Y, l', strtotime( $detail[ 'to_date' ] ) ) ); ?></p></h6>
      <?php else : ?>
        <h6 class="info">Date: <p><?php echo esc_attr( date( 'jS M Y, l', strtotime( $detail[ 'from_date' ] ) ) ); ?></p></h6>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
</div>
