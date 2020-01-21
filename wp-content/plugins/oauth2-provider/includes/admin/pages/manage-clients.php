<?php function wo_admin_manage_clients_page() {
	wp_enqueue_style( 'wo_admin' );
	wp_enqueue_script( 'wo_admin' );
	?>
    <div class="wrap">

        <h2><?php _e( 'Clients', 'wp-oauth' ); ?>
            <a class="add-new-h2 "
               href="<?php echo admin_url( 'admin.php?page=wo_add_client' ); ?>"
               title="Batch"><?php _e( 'Add New Client', 'wp-oauth' ); ?></a>
        </h2>

        <div class="section group">
            <div class="col span_4_of_6">
				<?php $CodeTableList = new WO_Table();
				$CodeTableList->prepare_items();
				$CodeTableList->display(); ?>
            </div>

            <div class="col span_2_of_6 sidebar">
                <div class="module hire-us">
                    <h3>Experience the Full OAuth Server Power</h3>
                    <div class="inner">
                        <p>
                            Upgrade to Pro with 30% OFF and receive priority support and all the grant types. Connect
                            any mobile application or desktop software to WordPress using grant types available in the
                            PRO version.
                        </p>
                        <p>
                            <strong>Save hundreds of hours of development</strong>.
                        </p>

                        <a href="https://wp-oauth.com/downloads/wp-oauth-server/" class="button button-primary">Download
                            PRO</a>

                        <h4>Use "PROME" at checkout for 30% OFF.</h4>
                        <strong>Current Build <?php echo _WO()->version; ?> (Community)</strong>
                    </div>
                </div>

            </div>
        </div>

    </div>
<?php }