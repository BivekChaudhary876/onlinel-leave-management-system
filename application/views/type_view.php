 <button class="open-app-modal button">Add new leave type</button>
 <div class="table-container">
     <table class="table table-light">
        <thead>
            <tr class="table-secondary">
                <th scope="col">S.No</th>
                <th scope="col">Name</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ( $types as $key => $type ) : ?>
                <tr>
                    <td><?php echo esc_attr( ( indexing() + $key + 1 ) ) ; ?></td>
                    <td><?php echo esc_attr( $type[ 'name' ] ) ; ?></td>
                    <td data-label="Actions">
                        <button class="btn-edit open-app-modal" data-value="<?php echo esc_attr( json_encode( $type ) ); ?>" data-id="<?= $type[ 'id' ] ?>"><?php icon( "edit" );?></button>
                        <button class="btn-delete delete-type" data-id="<?php echo $type[ 'id' ]; ?>"><?php icon( "delete" )?></button>
                        <button class="btn-view"><a href="type/details/<?php echo $type[ 'id' ]?>"><?php echo icon( "view" ); ?></a></button>
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