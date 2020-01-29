<?php
if( ! defined( 'ABSPATH' ) ) {
    return;
}
class WPQR_Metaboxes {
    /**
     * Renders the metabox for answers.
     * We will display saved answers and have the form to add new or delete old.
     *
     * @param  WP_Post $post
     * @return void       
     */
    public static function answers( $post ) {
        $post_id = $post->ID;
        // Get our answers
        $answers = get_post_meta( $post_id, '_wpqr_answers', true );
        ?>
        <table class="wpqr-answers form-table">
            <thead>
                <tr>
                    <td><strong><?php esc_html_e( 'Answer', 'wpqr' ); ?></strong></td>
                    <td><strong><?php esc_html_e( 'Points', 'wpqr' ); ?></strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                    for ( $i = 0; $i < 3; $i++ ) {
                        ?>
                        <tr>
                            <td><input type="text"   name="wpqr_answers[]" value="<?php echo isset( $answers[ $i ] ) && $answers[ $i ]['text'] ? $answers[ $i ]['text'] : ''; ?>" class="widefat"/></td>
                            <td><input type="number" name="wpqr_points[]" value="<?php echo isset( $answers[ $i ] ) && $answers[ $i ]['points'] ? $answers[ $i ]['points'] : 0; ?>"/></td>
                        </tr>
                        <?php
                    }
                ?> 
            </tbody> 
        </table>
        <?php
    }

      /**
     * Save Method. 
     * @param  integer $post_id 
     * @param  WP_Post $post    
     * @return void
     */
    public static function save( $post_id, $post ) {
        if( 'question' !== get_post_type( $post ) ) {
            return;
        }
        if ( wp_is_post_autosave( $post ) ) {
            return;
        }
        if ( defined( 'WP_AJAX' ) && WP_AJAX ) {
            return;
        }
        if ( ! current_user_can( 'edit_posts' ) ) {
            return;
        }
        if ( isset( $_POST['wpqr_answers'] ) && isset( $_POST['wpqr_points'] ) ) {
            $answers = array();
            
            // For each answer, get it's order (index) and the text
            foreach ( $_POST['wpqr_answers'] as $order => $answer) {
                $array = array( 'text' => $answer, 'points' => 0 );
                if ( isset( $_POST['wpqr_points'][ $order ] ) ) {
                    // If we have points inside with the same order (index), set it.
                    $array['points'] = floatval( $_POST['wpqr_points'][ $order ] );
                }
                $answers[ $order ] = $array;
            }
            
            update_post_meta( $post_id, '_wpqr_answers', $answers );
            
        } 
    }
}