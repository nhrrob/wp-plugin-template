<div class="nhrrob-plugin-enquiry-form" id="nhrrob-plugin-enquiry-form">

    <form action="" method="post">

        <div class="form-row">
            <label for="name"><?php _e( 'Name', 'nhrrob-plugin' ); ?></label>

            <input type="text" id="name" name="name" value="" required>
        </div>

        <div class="form-row">

            <?php wp_nonce_field( 'nhrrob-plugin-enquiry-form' ); ?>

            <input type="hidden" name="action" value="nhrrob_plugin_enquiry">
            <input type="submit" name="send_enquiry" value="<?php esc_attr_e( 'Send Enquiry', 'nhrrob-plugin' ); ?>">
        </div>

    </form>
</div>
