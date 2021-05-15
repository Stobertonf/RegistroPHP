<?php

/*Start*/
add_action( 'woocommerce_register_form_start', 'display_account_registration_field' );
add_action( 'woocommerce_edit_account_form_start', 'display_account_registration_field' );
function display_account_registration_field() {
    $user  = wp_get_current_user();
    $value = isset($_POST['billing_account_number']) ? esc_attr($_POST['billing_account_number']) : $user->billing_account_number;
    ?>
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
    <label for="reg_billing_account_name"><?php _e( 'Nome', 'woocommerce' ); ?> <span class="required">*</span></label>
    <input type="text"  class="input-text" name="reg_billing_account_name" id="reg_billing_account_name" value="<?php echo $value ?>" />
    </p>
    
     <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
    <label for="reg_billing_account_company"><?php _e( 'Empresa', 'woocommerce' ); ?> <span class="required">*</span></label>
    <input type="text"  class="input-text" name="billing_account_company" id="reg_billing_account_company" value="<?php echo $value ?>" />
    </p>
    
     <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
    <label for="reg_billing_account_email"><?php _e( 'E-mail', 'woocommerce' ); ?> <span class="required">*</span></label>
    <input type="text"  class="input-text" name="billing_account_email" id="reg_billing_account_email" value="<?php echo $value ?>" />
    </p>
    
     <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
    <label for="reg_billing_account_number"><?php _e( 'Telefone', 'woocommerce' ); ?> <span class="required">*</span></label>
    <input type="text"  class="input-text" name="billing_account_number" id="reg_billing_account_number" value="<?php echo $value ?>" />
    </p>
    <div class="clear"></div>
    <?php
}


add_filter( 'woocommerce_registration_errors', 'account_registration_field_validation', 10, 3 );
function account_registration_field_validation( $errors, $username, $email ) {
    if ( isset( $_POST['billing_account_number'] ) && empty( $_POST['billing_account_number'] ) ) {
        $errors->add( 'billing_account_number_error', __( '<strong>Error</strong>: account number is required!', 'woocommerce' ) );
    }
    return $errors;
}


add_action( 'woocommerce_created_customer', 'save_account_registration_field' );
function save_account_registration_field( $customer_id ) {
    if ( isset( $_POST['billing_account_number'] ) ) {
        update_user_meta( $customer_id, 'billing_account_number', sanitize_text_field( $_POST['billing_account_number'] ) );
    }
}


add_action( 'woocommerce_save_account_details', 'save_my_account_billing_account_number', 10, 1 );
function save_my_account_billing_account_number( $user_id ) {
    if( isset( $_POST['billing_account_number'] ) )
        update_user_meta( $user_id, 'billing_account_number', sanitize_text_field( $_POST['billing_account_number'] ) );
}


add_filter( 'woocommerce_customer_meta_fields', 'admin_user_custom_billing_field', 10, 1 );
function admin_user_custom_billing_field( $args ) {
    $args['billing']['fields']['billing_account_number'] = array(
        'label'         => __( 'Empresa', 'woocommerce' ),
        'description'   => '',
        'custom_attributes'   => array('maxlength' => 6),
    );
    return $args;
}

//
