  <?php if( is_admin() ){?>
    <button class="open-app-modal button">Add new Holiday</button>
  <?php } ?>
  <table class="table table-light">
    <thead>
      <tr class="table-secondary">
        <th scope="col">S.No</th>
        <th scope="col">Event</th>
        <th scope="col">Date</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($holidays as $key => $holiday) : ?>
        <td><?php echo esc_attr( ( indexing() +$key+1 ) ) ?></td>
        <td><?php echo esc_attr( $holiday[ 'event' ] ) ?></td>
        <td>
          <?php echo esc_attr( date( 'jS M Y, l', strtotime( $holiday['from_date' ] ) ) );?></td>

          <td>
            <?php if ( is_admin() ) : ?>
              <button class="btn-edit open-app-modal" data-value="<?php echo esc_attr( json_encode( $holiday ) ); ?>" data-id="    <?php echo esc_attr( $holiday[ 'id'] ); ?>">
                <?php icon( "fa-pencil-square-o" ); ?>
                <button class="btn-delete delete-holiday" data-id="<?= $holiday[ 'id' ] ?>"><?php echo icon('delete');?></button>
              </button>
            <?php endif; ?>
            <a href="holiday/details/<?= $holiday[ 'id' ] ?>"><?php echo icon('view');?></a>
          </td>

        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Pagination -->
  <?php pagination([
    'controller' => 'holiday',
    'total' => $total,
  ]); ?>

