 <button class="open-app-modal button">Add new Department</button>
 <table class="table table-light">
    <thead>
        <tr class="table-secondary">
            <th scope="col">S.No</th>
            <th scope="col">Name</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ( $departments as $key => $department ) : ?>
            <tr>
                <td><?php echo esc_attr( ( indexing() + $key + 1 ) ) ; ?></td>
                <td><?php echo esc_attr( $department[ 'name' ] ) ; ?></td>
                <td>
                    <button class="btn-edit open-app-modal" data-value="<?php echo esc_attr( json_encode( $department ) ); ?>" data-id="<?= $department[ 'id' ] ?>"><?php icon( "edit" );?></button>
                    <button class="btn-delete delete-department" data-id="<?php echo $department[ 'id' ]; ?>"><?php icon( "delete" )?></button>
                    <button class="btn-view"><a href="department/details/<?php echo $department[ 'id' ]?>"><?php echo icon( "view" ); ?></a></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
pagination([
  'total' => $total,
  'controller' => 'department'
]);