<div class="my-3 w-50 setting">
    <form method="POST" action="setting/save">
        <p>
            <label>Per Page</label>
            <input type="number" name="per_page" value="<?php echo $settings[ 'per_page' ]; ?>" class="form-control" placeholder="" />
        </p>

        <p>
            <label>Logo</label>
            <input type="text" name="logo" value="<?php echo $settings[ 'logo' ]; ?>" class="form-control" placeholder="" />
        </p>
        <p>
            <label>Header Color</label>
            <input type="color" name="header_bg" value="<?php echo $settings[ 'header_bg' ]; ?>" class="form-control" placeholder="" />
        </p>
        <p>
            <label>Primary Color</label>
            <input type="color" name="primary_bg" value="<?php echo $settings[ 'primary_bg' ]; ?>" class="form-control" placeholder="" />
        </p>
        <input type="submit" value="Save" class="p-1 btn btn-outline-success">
    </form>
</div>
 