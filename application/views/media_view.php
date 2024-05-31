<form id="media-form" method="post" enctype="multipart/form-data">
    <div class="trigger-file">
        <input type="hidden" id="id" name="id">
        <label for="file_to_upload" class="button">Choose File</label>
        <input type="file" name="file_to_upload" id="file_to_upload">
    </div>
</form>

<div class="file-list">
    <div class="switch-toggle">   
    <label class="switch">
        <input type="checkbox" id="bulk-toggle">
        <span class="slider round"></span>
    </label>
    <span id="bulk-mode-label">Bulk Mode Disabled</span>
    <input type="hidden" id="bulk-mode" value="false">
    </div>
    <ul>
        <?php foreach( $files as $index => $file ): ?>
            <?php if( $index % 8 === 0 && $index !== 0 ): ?>
            </ul>
            <ul>
            <?php endif; ?>
            <li class="media-file" data-id="<?php echo $file[ 'id' ]; ?>">
                <a href="media/details/<?php echo $file[ 'id' ]; ?>">
                    <img src="public/uploads/<?php echo htmlspecialchars( $file[ 'file_to_upload' ] ); ?>" alt="<?php echo $file[ 'title' ]; ?>" width="100">
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <button id="delete-selected" class="rejected-btn" style="display: none;">Delete</button>
</div>

<?php
pagination([
  'total' => $total,
  'controller' => 'media'
]);
?>
