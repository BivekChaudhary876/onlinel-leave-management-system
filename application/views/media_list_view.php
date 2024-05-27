<div id="media-popup-content">
    <ul>
        <?php foreach ($files as $file): ?>
            <li class="media-file" data-id="<?php echo $file['id']; ?>" data-title="<?php echo esc_attr($file['title']); ?>">
                <?php echo esc_attr($file['file_to_upload']); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>