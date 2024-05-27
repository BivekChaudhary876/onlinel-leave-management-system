<h5 class="card-title">File Details</h5>
<div class="poster">
    <div class="row poster-section">
        <div class="col-6">
            <?php foreach ( $details as $file) : ?>
                <img src="public/uploads/<?php echo htmlspecialchars( $file[ 'file_to_upload' ] ); ?>" alt="<?php echo $file['title'];?>" width="100">
                <button class="btn-delete delete-media" data-id="<?php echo $file[ 'id' ];?>"><?php echo icon('delete');?></button> 
            <?php endforeach; ?>
        </div>
        <div class="col-6">
            <?php foreach ($details as $file) : ?>
                <form action="media/save/<?php echo $file['id']; ?>" method="post">
                    <input type="text" class="login-input"name="descriptions" value="<?php echo htmlspecialchars( $file[ 'title' ] ); ?>"><br>
                    <input type="text" class="login-input"name="descriptions" value="<?php echo htmlspecialchars( $file[ 'descriptions' ] ); ?>"><br>
                    <button type="submit" class="button">Update</button>
                </form>
            <?php endforeach; ?>
        </div>
    </div>
</div>
