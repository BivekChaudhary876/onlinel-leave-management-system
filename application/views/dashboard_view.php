<?php $role = $_SESSION['current_user']['role']; ?>
<div class="my-3">
<?php if( $role == 'admin'): ?>
    <h1>Hello Dashboard</h1>
<?php else : ?>
    <h1>Hello User</h1>
<?php endif; ?>
</div>