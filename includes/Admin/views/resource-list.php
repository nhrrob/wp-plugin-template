<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e( 'Resource Book', 'nhrrob-plugin' ); ?></h1>

    <a href="<?php echo admin_url( 'admin.php?page=nhrrob-plugin&action=new' ); ?>" class="page-title-action"><?php _e( 'Add New', 'nhrrob-plugin' ); ?></a>

    <?php if ( isset( $_GET['inserted'] ) ) { ?>
        <div class="notice notice-success">
            <p><?php _e( 'Resource has been added successfully!', 'nhrrob-plugin' ); ?></p>
        </div>
    <?php } ?>

    <?php if ( isset( $_GET['resource-deleted'] ) && $_GET['resource-deleted'] == 'true' ) { ?>
        <div class="notice notice-success">
            <p><?php _e( 'Resource has been deleted successfully!', 'nhrrob-plugin' ); ?></p>
        </div>
    <?php } ?>

    <form action="" method="post">
        <?php
        $table = new Nhrrob\Plugin\Admin\Resource_List();
        $table->prepare_items();
        $table->search_box( 'search', 'search_id' );
        $table->display();
        ?>
    </form>
</div>
