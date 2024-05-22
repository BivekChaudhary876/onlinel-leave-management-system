<form method="POST" action="setting/save">
    <div class="form-content">
        <label>Per Page</label>
        <input type="number" name="per_page" value="<?php echo esc_attr( $settings[ 'per_page' ] ); ?>" class="input"/>
        <label>Logo</label>
        <input type="text" name="logo" value="<?php echo esc_attr( $settings[ 'logo' ] ); ?>" class="input"/>

        <label>Header Color</label>
        <input type="color" name="header_bg" value="<?php echo esc_attr( $settings[ 'header_bg' ] ); ?>" class="color-input form-control-color"/>

        <label>Primary Color</label>
        <input type="color" name="primary_bg" value="<?php echo esc_attr( $settings[ 'primary_bg' ] ); ?>" class="color-input form-control-color"/>

        <label>Secondary Color</label>
        <input type="color" name="secondary_bg" value="<?php echo esc_attr( $settings[ 'secondary_bg' ] ); ?>" class="color-input form-control-color">

        <label>Success Color</label>
        <input type="color" name="success_bg" value="<?php echo esc_attr( $settings[ 'success_bg' ] ); ?>" class="color-input form-control-color">

        <label>Warning Color</label>
        <input type="color" name="warning_bg" value="<?php echo esc_attr( $settings[ 'warning_bg' ] ); ?>" class="color-input form-control-color">

        <label>Danger Color</label>
        <input type="color" name="danger_bg" value="<?php echo esc_attr( $settings[ 'danger_bg' ] ); ?>" class="color-input form-control-color">


        <?php if( is_admin() ):?>
            <button type="submit" value="Save" class="button">Save</button>
        <?php endif;?>
    </div>
</form>

