<div class="">
    <button class="open-app-modal button">Add new user</button>
    <div class="table-row">
        <table class="table table-light">
            <thead>
                <tr class="table-secondary">
                    <th scope="col">S.No</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Department</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $users as $key => $user ) : ?>
                    <tr>
                        <td><?php echo esc_attr( indexing() + $key + 1 ) ?></td>
                        <td><?php echo esc_attr( $user[ 'username' ] ); ?></td>
                        <td><?php echo esc_attr( $user[ 'email' ] ); ?></td>
                        <td><?php echo esc_attr( $user[ 'department' ] ); ?></td>
                        <td> 
                            <button class="btn-edit open-app-modal " data-value="<?php echo esc_attr( json_encode( $user ) ); ?>" data-id="<?php echo esc_attr( $user[ 'id'] ); ?>">
                                <?php icon( "fa-pencil-square-o" ); ?>
                            </button>
                            <button class="btn-delete delete-user " data-id="<?= $user[ 'id' ] ?>">
                                <?php icon( "fa-trash" ); ?>
                            </button>
                            <a href='user/list/<?php echo esc_attr( $user[ 'id' ] ); ?>'><?php icon( "fa-eye" ); ?></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
pagination([
  "controller" => 'user/list',
  "total" => $total
]);
?>