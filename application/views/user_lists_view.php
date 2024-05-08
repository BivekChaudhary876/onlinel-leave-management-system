<div class="">
    <button class="open-app-modal button">Add new user</button>
    <table class="table table-striped table-light">
        <thead>
            <tr class="table-success text-start">
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
                    <td><?php echo ( indexing() + $key + 1 ) ?></td>
                    <td><?php echo $user[ 'username' ]; ?></td>
                    <td><?php echo $user[ 'email' ]; ?></td>
                    <td><?php echo $user[ 'department' ]; ?></td>
                    <td class="text-start">
                        <button class="btn-edit open-app-modal" data-value="<?php echo esc_attr( json_encode( $user ) ); ?>" data-id="    <?php echo esc_attr( $user[ 'id'] ); ?>">
                            <?php icon( "fa-pencil-square-o" ); ?>
                        </button>
                        <button class="btn-delete delete-user" data-id="<?= $user[ 'id' ] ?>">
                            <?php icon( "fa-trash" ); ?>
                        </button>
                        <a href='user/list/<?php echo $user[ 'id' ]; ?>'><?php icon( "fa-eye" ); ?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
pagination([
  "controller" => 'user/list',
  "total" => $total
]);
?>