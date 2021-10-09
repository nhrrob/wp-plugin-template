<div class="wrap">
    <h1><?php _e( 'New Resource', 'nhrrob-plugin' ); ?></h1>

    <form action="" method="post">
        <table class="form-table">
            <tbody>
                <tr class="row<?php echo $this->has_error( 'name' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row">
                        <label for="name"><?php _e( 'Name', 'nhrrob-plugin' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="name" id="name" class="regular-text" value="">

                        <?php if ( $this->has_error( 'name' ) ) { ?>
                            <p class="description error"><?php echo $this->get_error( 'name' ); ?></p>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="resource"><?php _e( 'Resource', 'nhrrob-plugin' ); ?></label>
                    </th>
                    <td>
                        <textarea class="regular-text" name="resource" id="resource"></textarea>
                    </td>
                </tr>
            </tbody>
        </table>

        <?php wp_nonce_field( 'new-resource' ); ?>
        <?php submit_button( __( 'Add Resource', 'nhrrob-plugin' ), 'primary', 'submit_resource' ); ?>
    </form>
</div>
