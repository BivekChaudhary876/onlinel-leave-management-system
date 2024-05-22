<h5 class="card-title">File Details</h5>
<div class="poster">
    <div class="row poster-section">
        <div class="col-6">
            <?php foreach ($details as $file) : ?>
                <img src="public/uploads/<?php echo htmlspecialchars($file['file_to_upload']); ?>" alt="" width="100">
            <?php endforeach; ?>
        </div>
        <div class="col-6">
            <?php foreach ($details as $file) : ?>
                <form action="media/update_file_info/<?php echo $file['id']; ?>" method="post">
                <input type="text" class="login-input"name="descriptions" value="<?php echo htmlspecialchars($file['title']); ?>"><br>
                    <input type="text" class="login-input"name="descriptions" value="<?php echo htmlspecialchars($file['descriptions']); ?>"><br>
                    <button type="submit">Save</button>
                </form>
            <?php endforeach; ?>
        </div>
    </div>
</div>
