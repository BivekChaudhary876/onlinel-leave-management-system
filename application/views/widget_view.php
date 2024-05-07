<h1>hi i am from widget section</h1>

<div class="widget-lists-wrapper">
    <table class="table table-striped table-light">
        <thead>
            <tr class="table-success">
                <th>Name</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ( $installed_widgets as $key => $widget ): ?>
                <?php 
                    $is_active = in_array( $widget, $active_widgets );
                ?>
                <tr>
                    <td class="name"><?php echo  $widget; ?></td>
                    <td class="status"><?php echo $is_active ? 'Active' : 'Inactive'; ?></td>
                    <td>
                        <button type="button" data-name="<?php echo $widget; ?>" class="widget-action btn btn-primary">
                            <?php echo $is_active ? 'Deactivate' : 'Activate'; ?>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

