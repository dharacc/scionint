<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php 
	$action =	""; $active	= 'class="selected"';
	if(isset($_GET['tab']))
        $action	= esc_attr($_GET['tab']);
        $this->no_addon_activated = $this->anyAddonActivated();        
	?>

<div id="container"  class="pieregister-admin">
    <div class="right_section pro-page">
        <div class="pro-features-top">
            <div class="top-left">
                <div class="welcome-text">
                    <h3>Welcome to Pie Register</h3>
                </div>
                <div class="welcome-description">
                    <p>
                    Pie Register helps you create registration forms in minutes with a simple drag and drop form builder. No coding required. You can build simple to the most robust forms and registration flows using the various form fields and UI controls. Customize the registration process using the many add-ons included with the premium version to make your website exclusive, spam-free, and secure.
                    </p>
                </div>
                <div class="go-pro-button">
                    <a href="https://pieregister.com/plan-and-pricing/" target="_blank">Get Started</a>
                </div>
            </div>
            <div class="top-right">
                <div class="right-img-pro">
                    <img src="<?php echo plugins_url("assets/images/pro/pieregister-premium-features.png", dirname(__FILE__) ); ?>" alt="Pie Register Pro">
                </div>
            </div>
        </div>
        
        <ul class="go-pro-tabs">
            <li <?php echo $active; ?>><a href="admin.php?page=pie-pro-features"><?php _e("Addons","pie-register") ?></a></li>
        </ul>
        <div class="pane">
        	<?php if( 'addons' == 'addons' ) { ?> 
            	<div id="tab2" class="tab-content">
                <div class="addons-container-section">
                    <div class="addon-row">
                        <div class="addon-column margin-right">
                            <div class="addon-container">
                                <img class="addon-img" src="<?php echo plugins_url("assets/images/pro/6.jpg", dirname(__FILE__) ); ?>" alt="Authorize.net Payment Addon">
                                <div class="">
                                    <div class="addon-content-container">
                                        <h3>Authorize.net Payment Addon</h3>
                                        <p>Use Authorize.net addon to process membership payments using Pie Register.</p>
                                        <a class="get-addon" href="https://store.genetech.co/cart/?add-to-cart=878">Get this addon - $19.99</a>
                                        <a class="read-more" href="https://pieregister.com/addons/authorize-net-payment-addon/?utm_source=plugin-dashboard&utm_medium=goprodashboard&utm_campaign=go_pro_admin&utm_content=addons"> Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="addon-column margin-right">
                            <div class="addon-container">
                                <img class="addon-img" src="<?php echo plugins_url("assets/images/pro/5.jpg", dirname(__FILE__) ); ?>" alt="Stripe Payment Addon">
                                <div class="">
                                    <div class="addon-content-container">
                                        <h3>Stripe Payment Addon</h3>
                                        <p>Use Stripe addon to process membership payments using Pie Register.</p>
                                        <a class="get-addon" href="https://store.genetech.co/cart/?add-to-cart=835">Get this addon - $19.99</a>
                                        <a class="read-more" href="https://pieregister.com/addons/stripe-payment-addon/?utm_source=plugin-dashboard&utm_medium=goprodashboard&utm_campaign=go_pro_admin&utm_content=addons"> Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="addon-column margin-right">
                            <div class="addon-container">
                                <img class="addon-img" src="<?php echo plugins_url("assets/images/pro/3.jpg", dirname(__FILE__) ); ?>" alt="Two-step Authentication Addon">
                                <div class="">
                                    <div class="addon-content-container">
                                        <h3>Two-step Authentication Addon</h3>
                                        <p>Add an additional security layer by having users verify registration via SMS (TWILIO).</p>
                                        <a class="get-addon" href="https://store.genetech.co/cart/?add-to-cart=200">Get this addon - $19.99</a>
                                        <a class="read-more" href="https://pieregister.com/addons/two-step-authentication-addon/?utm_source=plugin-dashboard&utm_medium=goprodashboard&utm_campaign=go_pro_admin&utm_content=addons"> Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="addon-column margin-right">
                            <div class="addon-container">
                                <img class="addon-img" src="<?php echo plugins_url("assets/images/pro/4.jpg", dirname(__FILE__) ); ?>" alt="MailChimp Addon">
                                <div class="">
                                    <div class="addon-content-container">
                                        <h3>MailChimp Addon</h3>
                                        <p>Use Pie Register to export your site users into MailChimp lists to send communication, sales and marketing emails.</p>
                                        <a class="get-addon" href="https://store.genetech.co/cart/?add-to-cart=197">Get this addon - $19.99</a>
                                        <a class="read-more" href="https://pieregister.com/addons/mailchimp-addon/?utm_source=plugin-dashboard&utm_medium=goprodashboard&utm_campaign=go_pro_admin&utm_content=addons"> Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="addon-column margin-right">
                            <div class="addon-container">
                                <img class="addon-img" src="<?php echo plugins_url("assets/images/pro/8.jpg", dirname(__FILE__) ); ?>" alt="Geolocation Addon">
                                <div class="">
                                    <div class="addon-content-container">
                                        <h3>Bulk Email Addon</h3>
                                        <p>Bulk Email addon gives Admin the ability to send email in bulk to all the registered users at once.</p>
                                        <a class="get-addon" href="https://store.genetech.co/cart/?add-to-cart=1190">Get this addon - $9.99</a>
                                        <a class="read-more" href="https://pieregister.com/addons/bulk-email-addon/?utm_source=plugin-dashboard&utm_medium=goprodashboard&utm_campaign=go_pro_admin&utm_content=addons"> Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="addon-column margin-right">
                            <div class="addon-container">
                                <img class="addon-img" src="<?php echo plugins_url("assets/images/pro/1.jpg", dirname(__FILE__) ); ?>" alt="Social Login Addon">
                                <div class="">
                                    <div class="addon-content-container">
                                        <h3>Social Login Addon</h3>
                                        <p>Let your site or blog users to login via their Facebook, Twitter, Google, LinkedIn and WordPress accounts.</p>
                                        <a class="get-addon" href="https://store.genetech.co/cart/?add-to-cart=199">Get this addon - $14.99</a>
                                        <a class="read-more" href="https://pieregister.com/addons/social-login-addon/?utm_source=plugin-dashboard&utm_medium=goprodashboard&utm_campaign=go_pro_admin&utm_content=addons"> Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="addon-column margin-right">
                            <div class="addon-container">
                                <img class="addon-img" src="<?php echo plugins_url("assets/images/pro/2.jpg", dirname(__FILE__) ); ?>" alt="Profile Search Addon">
                                <div class="">
                                    <div class="addon-content-container">
                                        <h3>Profile Search Addon</h3>
                                        <p>With the Profile Search tool, admin can provide users the feature to search or filter to display user data.</p>
                                        <a class="get-addon" href="https://store.genetech.co/cart/?add-to-cart=198">Get this addon - $7.99</a>
                                        <a class="read-more" href="https://pieregister.com/addons/profile-search-addon/?utm_source=plugin-dashboard&utm_medium=goprodashboard&utm_campaign=go_pro_admin&utm_content=addons"> Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="addon-column margin-right">
                            <div class="addon-container">
                                <img class="addon-img" src="<?php echo plugins_url("assets/images/pro/7.png", dirname(__FILE__) ); ?>" alt="Geolocation Addon">
                                <div class="">
                                    <div class="addon-content-container">
                                        <h3>Geolocation Addon</h3>
                                        <p>Allows you to collect and store your website visitor’s geolocation details along with their form submission data.</p>
                                        <a class="get-addon" href="https://store.genetech.co/cart/?add-to-cart=1190">Get this addon - $12.99</a>
                                        <a class="read-more" href="https://pieregister.com/addons/geolocation/?utm_source=plugin-dashboard&utm_medium=goprodashboard&utm_campaign=go_pro_admin&utm_content=addons"> Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="addon-column margin-right">
                            <div class="addon-container">
                                <img class="addon-img" src="<?php echo plugins_url("assets/images/pro/9.jpg", dirname(__FILE__) ); ?>" alt="WooCommerce Addon">
                                <div class="">
                                    <div class="addon-content-container">
                                        <h3>WooCommerce Addon</h3>
                                        <p>With the WooCommerce Addon, you can now add fields for billing and shipping address to your PR forms.</p>
                                        <a class="get-addon" href="https://store.genetech.co/cart/?add-to-cart=8226">Get this addon - $9.99</a>
                                        <a class="read-more" href="https://pieregister.com/addons/woocommerce-addon/"> Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="addon-column margin-right">
                            <div class="addon-container">
                                <img class="addon-img" src="<?php echo plugins_url("assets/images/pro/10.jpg", dirname(__FILE__) ); ?>" alt="Field Visibility Addon">
                                <div class="">
                                    <div class="addon-content-container">
                                        <h3>Field Visibility Addon</h3>
                                        <p>Allows you to show or hide certain fields on the front-end registration form or the User’s Profile page.</p>
                                        <a class="get-addon" href="https://store.genetech.co/cart/?add-to-cart=8393">Get this addon - $19.99</a>
                                        <a class="read-more" href="https://pieregister.com/addons/field-visibility-addon/"> Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>			
			<?php  } ?>
        </div>
    </div>
</div>