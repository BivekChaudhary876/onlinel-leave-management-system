<div class="w-50 setting">
    <form method="POST" action="setting/save">
        <p>
            <label>Per Page</label>
            <input type="number" name="per_page" value="<?php echo esc_attr( $settings[ 'per_page' ] ); ?>" class="input" placeholder="" />
        </p>

        <p>
            <label>Logo</label>
            <input type="text" name="logo" value="<?php echo esc_attr( $settings[ 'logo' ] ); ?>" class="input" placeholder="" />
        </p>
        <p>
            <label>Header Color</label>
            <input type="color" name="header_bg" value="<?php echo esc_attr( $settings[ 'header_bg' ] ); ?>" class="color-input form-control-color" placeholder="" />
        </p>
        <p>
            <label>Primary Color</label>
            <input type="color" name="primary_bg" value="<?php echo esc_attr( $settings[ 'primary_bg' ] ); ?>" class="color-input form-control-color" placeholder="" />
        </p>
        <input type="submit" value="Save" class="button">
    </form>
</div>
 