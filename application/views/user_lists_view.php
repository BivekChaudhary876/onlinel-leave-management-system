<div >
    <table class="table">
    <thead>
        <tr>
            <th>User ID</th>
            <th>User Name</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach( $users as $user ): ?>
        <tr>
            <td><?php  echo $user['id'] ?></td>
            <td><?php echo $user['username']; ?></td>
            <td><?php  echo $user['password']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
