<div class="">
  <button class="open-app-modal button">Add new Holiday</button>
  <table class="table table-striped table-light">
    <thead>
      <tr class="table-success text-start">
        <th scope="col">S.No</th>
        <th scope="col">Event</th>
        <th scope="col">Date</th>
        <?php echo action_header();?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($holidays as $key => $holiday) : ?>
        <td><?php echo ( indexing() + $key+1 ) ?></td>
        <td><?php echo $holiday[ 'event' ] ?></td>
        <td><?php echo $holiday[ 'from_date' ] ?></td>
        <?php if ( is_admin() ) : ?>
          <td class="text-start">
            <button class="btn-edit open-app-modal" data-value="<?php echo esc_attr( json_encode( $holiday ) ); ?>" data-id="    <?php echo esc_attr( $holiday[ 'id'] ); ?>">
              <?php icon( "fa-pencil-square-o" ); ?>
            </button>
            <button class="btn-delete delete-holiday" data-id="<?= $holiday[ 'id' ] ?>"><?php echo icon('delete');?></button>
            <a href="holiday/details/<?= $holiday[ 'id' ] ?>"><?php echo icon('view');?></a>
          </td>
        <?php endif; ?>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>

<!-- Pagination -->
<?php pagination([
  'controller' => 'holiday',
  'total' => $total,
]); ?>

