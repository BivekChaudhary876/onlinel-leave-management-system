<div class="widget-lists-wrapper">
    <table class="table table-light">
        <thead>
            <tr class="table-secondary">
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
                        <label class="switch">
                            <input type="checkbox" class="widget-action" data-name="<?php echo $widget; ?>" <?php echo $is_active ? 'checked' : ''; ?>>
                            <span class="slider round"></span>
                        </label>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

