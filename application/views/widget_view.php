<div class="main">
    <div class="filter">
        <form method="GET" action="">
            <select name="selected_status" class="select">
                <?php foreach ($widget_status as $status): ?>
                    <option value="<?= $status['status'] ?>" <?= $selected_status === $status['status'] ? 'selected' : '' ?>>
                        <?= ucfirst($status['status']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Filter" class="button">
        </form>
    </div>


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
                <?php foreach ($installed_widgets as $key => $widget): ?>
                    <?php 
                    $is_active = in_array($widget, $active_widgets);
                    // Skip this widget if it doesn't match the selected status
                    if ($selected_status !== 'all' && (($selected_status === 'active' && !$is_active) || ($selected_status === 'inactive' && $is_active))) {
                        continue;
                    }
                    ?>
                    <tr>
                        <td class="name"><?= $widget ?></td>
                        <td class="status"><?= $is_active ? 'Active' : 'Inactive' ?></td>
                        <td>
                            <label class="switch">
                                <input type="checkbox" class="widget-action" data-name="<?= $widget ?>" <?= $is_active ? 'checked' : '' ?>>
                                <span class="slider round"></span>
                            </label>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>