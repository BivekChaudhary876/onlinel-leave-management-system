<form id="media-form" method="post" enctype="multipart/form-data">
    <div class="trigger-file">
        <input type="hidden" id="id" name="id">
        <label for="file_to_upload" class="button">Choose File</label>
        <input type="file" name="file_to_upload" id="file_to_upload">
    </div>
</form>

<?php if ( !empty( $files ) ): ?>
    <div class="file-list" style="gap:16px;">
        <ul>
            <?php foreach( $files as $index => $file ): ?>
                <?php if( $index % 8 === 0 && $index !== 0 ): ?>
                </ul>
                <ul>
                <?php endif; ?>
                <li class="media-file">
                    <a href="media/details/<?php echo $file['id']; ?>">
                        <img src="public/uploads/<?php echo htmlspecialchars( $file[ 'file_to_upload' ] ); ?>" alt="<?php echo $file['title'];?>" width="100">
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php else: ?>
    <p>No files uploaded yet.</p>
    <?php endif; ?>