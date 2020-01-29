<?php

class Mo_API_Authentication_Admin_License {
    public static function emit_css() {
        ?>
        <style>
            .mo-oauth-licensing-container {
                margin: 0 auto;
                padding: 10px;
            }
            .mo-oauth-licensing-header {
                /* text-align: center; */
            }
            .moct-align-left {
                text-align: left;
            }
            .moct-align-right {
                text-align: right;
            }
            .moct-align-center {
                text-align: center;
            }
            .moc-licensing-notice {
                width: 90%;
                margin-top: 5%;
            }
            .moc-licensing-plan-header {
                font-size: 32px;
                font-variant: small-caps;
                border-radius: 1rem 1rem 0px 0px;
            }
            .moc-licensing-plan-header hr {
                margin: 1.5rem 0;
            }
            .moc-licensing-plan-feature-list {
                font-size: 12px;
                padding-top: 10px;
            }
            .moc-licensing-plan-feature-list li {
                text-align: left;
                padding: 10px;
                border: none;
            }
            .moc-licensing-plan-feature-list li:nth-child(even) {
                background-color: #f0f0f0;
            }
            .moc-licensing-plan-usp {
                font-size: 18px;
                font-weight: 500;
                padding-bottom: 10px;
            }
            .moc-licensing-plan-price {
                font-size: 24px;
                font-weight: 400;
            }
            .moc-licensing-plan-name {
                font-size: 32px;
                font-weight: 500;
            }
            .moc-licensing-plan {
                border-radius: 1rem;
                border: 1px solid #00788E;
                margin: 0.5rem 0;
                box-shadow: 0 4px 8px 0 rgba(0,0,0,0.4);
                transition: 0.3s;
            }
            .moc-licensing-plan:hover {
                margin-top: -.25rem;
                margin-bottom: .25rem;
                /* border: 1px solid #17a2b8; */
                border: 1px solid rgb(112, 165, 245);
                box-shadow: 0 16px 32px 0 rgba(112, 165, 245, 0.8);
            }
            .moc-lp-buy-btn {
                border-radius: 5rem;
                letter-spacing: .1rem;
                font-weight: bold;
                padding: 1rem;
                opacity: 0.7;
            }
            .moc-lp-buy-btn:hover {
                opacity: 1;
            }
            .moc-lp-highlight {
                box-shadow: 0 16px 32px 0 #563d7c66;
                border: 1px solid #2B1251;
            }
            .moc-lp-highlight:hover {
                border: 1px solid #563d7c;
                box-shadow: 0 16px 32px 0 #563d7ccc;
            }
            .btn-purple {
                color: #ffffff;
                background: radial-gradient(circle, #563d7c, #452c6b);
                border-color: #563d7c;
            }
            .btn-purple:hover {
                background: radial-gradient(circle, #452c6b, #563d7c);
            }
        </style>
        <?php
    }
    public static function mo_api_authentication_licensing_page(){
        self::emit_css();
        ?>
        <!-- Important JSForms -->
        <input type="hidden" value="<?php echo mo_api_authentication_is_customer_registered();?>" id="mo_customer_registered">
        <form style="display:none;" id="loginform"
              action="<?php echo get_option( 'host_name' ) . '/moas/login'; ?>"
              target="_blank" method="post">
            <input type="email" name="username" value="<?php echo get_option( 'mo_api_authentication_admin_email' ); ?>"/>
            <input type="text" name="redirectUrl"
                   value="<?php echo get_option( 'host_name' ) . '/moas/initializepayment'; ?>"/>
            <input type="text" name="requestOrigin" id="requestOrigin"/>
        </form>
        <form style="display:none;" id="viewlicensekeys"
              action="<?php echo get_option( 'host_name' ) . '/moas/login'; ?>"
              target="_blank" method="post">
            <input type="email" name="username" value="<?php echo get_option( 'mo_api_authentication_admin_email' ); ?>"/>
            <input type="text" name="redirectUrl"
                   value="<?php echo get_option( 'host_name' ) . '/moas/viewlicensekeys'; ?>"/>
        </form>
        <!-- End Important JSForms -->
        <!-- Licensing Table -->
        <div class="mo-oauth-licensing-container">
            <div class="mo-oauth-licensing-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6 moct-align-right">
                            &nbsp;
                        </div>
                        <div class="col-6 moct-align-right">
                            &nbsp;
                        </div>
                    </div>
                    <div class="row justify-content-center mx-15">
                        <!-- Licensing Plans -->
                        <!-- Standard Plan -->
                        <div class="col-3 moct-align-center">
                            <div class="moc-licensing-plan card-body">
                                <!-- Plan Header -->
                                <div class="moc-licensing-plan-header">
                                    <div class="moc-licensing-plan-name">custom</div>
                                    <div class="moc-licensing-plan-price"><sup>$</sup>99<sup>*</sup></div>
                                    <div class="moc-licensing-plan-usp">( Choose a Authentication <br>Method of Your Choice )<br></div>
                                </div>
                                <button class="btn btn-block btn-info text-uppercase moc-lp-buy-btn" onclick="upgradeform('wp_rest_api_authentication_custom_plan')">Buy Now</button>
                                <!-- Plan Header End -->
                                <!-- Plan Feature List -->
                                <div class="moc-licensing-plan-feature-list">
                                    <ul>
                                        <li>&#9989;&emsp;Authentication using any 1 Method: <br>
                                        <li>&emsp;API Key Authentication OR</li>
                                        <li>&emsp;Basic Authentication OR</li>
                                        <li>&emsp;JWT Authentication OR</li>
                                        <li>&emsp;OAuth 2.0 Authentication OR</li>
                                        <li>&emsp;</li>
                                        <li>&emsp;</li>
                                        <li>&emsp;</li>
                                        <li>&emsp;</li>
                                        <li>&emsp;</li>
                                        <li>&#9989;&emsp;Restrict Public Access to WP REST APIs</li>
                                        <li>&#9989;&emsp;Support for GET, POST, PUT & DELETE methods</li>
                                        <li>&#9989;&emsp;Role based Access to APIs</li>
                                        <li>&#9989;&emsp;Custom Token Expiry</li>
                                        <li>&#9989;&emsp;Custom Header</li>
                                        <li>&#9989;&emsp;Exclude REST APIs</li>
                                        <li>&#10060;&emsp;<span class="text-muted">API Authentication for Third Party Provider</span></li>
                                        <li>&#10060;&emsp;<span class="text-muted">Supports WooCommerce, BuddyPress API Authentication</span></li>
                                        <!--                                        <li>&#10060;&emsp;<span class="text-muted">WP hooks to read token, login event and extend plugin functionality</span></li>-->
                                        <!--                                        <li>&#10060;&emsp;<span class="text-muted">End User Login Reports / Analytics</span></li>-->
                                    </ul>
                                </div>
                                <!-- Plan Feature List End -->
                            </div>
                        </div>
                        <!-- Standard Plan End -->
                        <!-- Premium Plan -->
                        <div class="col-3 moct-align-center">
                            <div class="moc-licensing-plan card-body">
                                <!-- Plan Header -->
                                <div class="moc-licensing-plan-header">
                                    <div class="moc-licensing-plan-name">premium</div>
                                    <div class="moc-licensing-plan-price"><sup>$</sup>249<sup>*</sup></div>
                                    <div class="moc-licensing-plan-usp">( Multiple Authentication <br>Method )</div>
                                </div>
                                <button class="btn btn-block btn-info text-uppercase moc-lp-buy-btn" onclick="upgradeform('wp_rest_api_authentication_premium_plan')">Buy Now</button>

                                <!-- Plan Header End -->
                                <!-- Plan Feature List -->
                                <div class="moc-licensing-plan-feature-list">
                                    <ul>
                                        <li>&#9989;&emsp;Single App Support</li>
                                        <li>&#9989;&emsp;User specific API keys (Access to only specific user data)</li>
                                        <li>&#9989;&emsp;Advanced Basic Authentication<br> 1. Using Username : Password <br> 2. Using Client ID : Client Secret</li>
                                        <li>&#9989;&emsp;JWT Authentication</li>
                                        <li>&#9989;&emsp;Signature Validation : HSA & RSA Signing</li>
                                        <li>&#9989;&emsp;OAuth 2.0 Authentication<br> 1. Client Credentials Grant<br> 2. Password Grant</li>
                                        <li>&#9989;&emsp;Access Token & JWT Token support</li>
                                        <li>&#9989;&emsp;Refresh & Revoke Tokens</li>
                                        <li>&#9989;&emsp;Restrict Public Access to WP REST APIs</li>
                                        <li>&#9989;&emsp;Support for GET, POST, PUT & DELETE methods</li>
                                        <li>&#9989;&emsp;Role based Access to APIs</li>
                                        <li>&#9989;&emsp;Custom Token Expiry</li>
                                        <li>&#9989;&emsp;Custom Header</li>
                                        <li>&#9989;&emsp;Exclude REST APIs</li>
                                        <li>&#10060;&emsp;<span class="text-muted">API Authentication for Third Party Provider</span></li>
                                        <li>&#10060;&emsp;<span class="text-muted">Supports WooCommerce, BuddyPress API Authentication</span></li>
<!--                                        <li>&#10060;&emsp;<span class="text-muted">WP hooks to read token, login event and extend plugin functionality</span></li>-->
<!--                                        <li>&#10060;&emsp;<span class="text-muted">End User Login Reports / Analytics</span></li>-->
                                    </ul>
                                </div>
                                <!-- Plan Feature List End -->
                            </div>
                        </div>
                        <!-- Premium Plan End -->
                        <!-- Enterprise Plan -->
                        <div class="col-3 moct-align-center">
                            <div class="moc-licensing-plan card-body moc-lp-highlight">
                                <!-- Plan Header -->
                                <div class="moc-licensing-plan-header">
                                    <div class="moc-licensing-plan-name">enterprise</div>
                                    <div class="moc-licensing-plan-price"><sup>$</sup>349<sup>*</sup></div>
                                    <div class="moc-licensing-plan-usp">( Third Party API <br>Authentication )</div>
                                </div>
                                <button class="btn btn-block btn-purple text-uppercase moc-lp-buy-btn" onclick="upgradeform('wp_rest_api_authentication_enterprise_plan')">Buy Now</button>
                                <!-- Plan Header End -->
                                <!-- Plan Feature List -->
                                <div class="moc-licensing-plan-feature-list">
                                    <ul>
                                        <li>&#9989;&emsp;Single App Support</li>
                                        <li>&#9989;&emsp;User specific API keys (Access to only specific user data)</li>
                                        <li>&#9989;&emsp;Advanced Basic Authentication<br> 1. Using Username : Password <br> 2. Using Client ID : Client Secret</li>
                                        <li>&#9989;&emsp;JWT Authentication</li>
                                        <li>&#9989;&emsp;Signature Validation : HSA & RSA Signing</li>
                                        <li>&#9989;&emsp;OAuth 2.0 Authentication<br> 1. Client Credentials Grant<br> 2. Password Grant</li>
                                        <li>&#9989;&emsp;Access Token & JWT Token support</li>
                                        <li>&#9989;&emsp;Refresh & Revoke Tokens</li>
                                        <li>&#9989;&emsp;Restrict Public Access to WP REST APIs</li>
                                        <li>&#9989;&emsp;Support for GET, POST, PUT & DELETE methods</li>
                                        <li>&#9989;&emsp;Role based Access to APIs</li>
                                        <li>&#9989;&emsp;Custom Token Expiry</li>
                                        <li>&#9989;&emsp;Custom Header</li>
                                        <li>&#9989;&emsp;Exclude REST APIs</li>
                                        <li>&#9989;&emsp;API Authentication for Third Party Provider</li>
                                        <li>&#9989;&emsp;Supports WooCommerce, BuddyPress API Authentication</li>
                                    </ul>
                                </div>
                                <!-- Plan Feature List End -->
                            </div>
                        </div>
                        <!-- Enterprise Plan End -->
                        <!-- Licensing Plans End -->
                        <div class="moc-licensing-notice">
                            <span style="color: red;">*</span>Cost applicable for one instance only. Licenses are perpetual and the Support Plan includes 12 months of maintenance (support and version updates). You can renew maintenance after 12 months at 50% of the current license cost.
                            <p><span style="color: red;">*</span><strong>MultiSite Network Support</strong>
                                There is an additional cost for the number of subsites in Multisite Network.</p>
                            <h4>10 Days Return Policy</h4>
                            <p>At miniOrange, we want to ensure you are 100% happy with your purchase. If the premium plugin you purchased is not working as advertised and you've attempted to resolve any issues with our support team, which couldn't get resolved. We will refund the whole amount within 10 days of the purchase. Please email us at <a href="mailto:info@xecurify.com" target="_blank">info@xecurify.com</a> for any queries regarding the return policy.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Licensing Table -->
        <a  id="mobacktoaccountsetup" style="display:none;" href="<?php echo add_query_arg( array( 'tab' => 'account' ), htmlentities( $_SERVER['REQUEST_URI'] ) ); ?>">Back</a>
        <!-- JSForms Controllers -->
        <script>
            function upgradeform(planType) {
                if(planType === "") {
                    location.href = "https://wordpress.org/plugins/miniorange-login-with-eve-online-google-facebook/";
                    return;
                } else {
                    jQuery('#requestOrigin').val(planType);
                    if(jQuery('#mo_customer_registered').val()==1)
                        jQuery('#loginform').submit();
                    else{
                        location.href = jQuery('#mobacktoaccountsetup').attr('href');
                    }
                }

            }

            function getlicensekeys() {
                // if(jQuery('#mo_customer_registered').val()==1)
                jQuery('#viewlicensekeys').submit();
            }
        </script>
        <!-- End JSForms Controllers -->
        <?php
    }
}