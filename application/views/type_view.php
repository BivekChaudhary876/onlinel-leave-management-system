<div class="">
    <button class="open-app-modal button">Add new leave type</button>
    <table class="table table-striped table-light">
        <thead>
            <tr class="table-success text-start">
                <th scope="col">S.No</th>
                <th scope="col">Name</th>
                <?php echo action_header();?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ( $types as $key => $type ) : ?>
                <tr>
                    <td><?php echo ( indexing() + $key + 1 ) ?></td>
                    <td><?php echo $type[ 'name' ] ?></td>
                    <td class="text-start">
                        <button class="btn-edit open-app-modal" data-value="<?php echo esc_attr( json_encode( $type ) ); ?>" data-id="<?= $type[ 'id' ] ?>"><?php icon( "edit" );?></button>
                        <button class="btn-delete delete-type" data-id="<?= $type[ 'id' ] ?>"><?php icon( "delete" )?></button>
                        <a href="type/details/<?php echo $type[ 'id' ]?>"><?php echo icon( "view" ); ?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
pagination([
  'total' => $total,
  'controller' => 'type'
]);
?>