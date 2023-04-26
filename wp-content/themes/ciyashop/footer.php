<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package CiyaShop
 */

?>
			</div><!-- .container -->
		</div><!-- .content-wrapper -->

	</div><!-- #content .wrapper -->

	<?php
	/**
	 * Fires before footer.
	 *
	 * @visible true
	 */
	do_action( 'ciyashop_before_footer' );
	?>

	<footer id="colophon" class="site-footer">
		<div class="<?php ciyashop_footer_wrapper_classes(); ?>">

			<?php
			/**
			 * Hook: ciyashop_footer
			 *
			 * @Functions hooked in to ciyashop_footer action
			 * @hooked ciyashop_footer_main - 10
			 *
			 * @visible true
			 */
			do_action( 'ciyashop_footer' );
			?>

		</div>
	</footer><!-- #colophon -->

	<?php
	/**
	 * Fires after footer.
	 *
	 * @Functions hooked in to ciyashop_after_footer action hook.
	 * @hooked ciyashop_bak_to_top - 10
	 *
	 * @visible true
	 */
	do_action( 'ciyashop_after_footer' );
	?>

</div><!-- #page -->

<?php
/**
 * Fires after page wrapper.
 *
 * @Functions hooked in to ciyashop_after_page_wrapper action
 * @hooked ciyashop_cookie_notice - 10
 *
 * @visible true
 */
do_action( 'ciyashop_after_page_wrapper' );

if ( is_user_logged_in() ) {
$uvid=get_current_user_id();
$data = get_user_meta ( $uvid);
$current_user = wp_get_current_user();
  
   $country = get_user_meta( $uvid, 'billing_country', true );
     if($country=='IN'){$country='India';}
     if($country=='USA'){$country='United States';}
     if($country=='UAE'){$country='Unites Arab Emirates'; }
}

?>
<script>
<?php
if ( is_product() ) 
{
 
 if ( is_user_logged_in() ) {
 ?>
    $("input[name='your-name']").val('<?php echo $data['nickname'][0];?>');
    $("input[name='mobile']").val('<?php echo $data['billing_phone'][0];?>');
     $("input[name='your-email']").val('<?php echo $current_user->user_email;?>');
    $("input[name='your-country']").val('<?php echo $country;?>');
   
 <?php
 }
} 
?>
</script>
<?php wp_footer(); ?>
<Style>

</Style>
<script>
var url =window.location.href;
oldcountrycode=getCookie('old_user_country');
countrycode=getCookie('wcacr_user_country');
 

 if((url=='https://www.scionintl.com/' && countrycode=='IN') || (url=='https://www.scionintl.com/' && countrycode=='AE') || (url=='https://www.scionintl.com/' && countrycode=='US'))
 {
	 
	 if(countrycode=='IN'){
		 if(oldcountrycode!='IN') {woocs_redirect_custom('INR') ; location.href='https://www.scionintl.com/india/'; createCookie('old_user_country',oldcountrycode,-1);}
	     
	 }
	 if(countrycode=='US'){ if(oldcountrycode!='US') {woocs_redirect_custom('USD') ; location.href='https://www.scionintl.com/usa/'; createCookie('old_user_country',oldcountrycode,-1);}}
	 if(countrycode=='AE'){if(oldcountrycode!='AE') {woocs_redirect_custom('AED') ; location.href='https://www.scionintl.com/uae/'; createCookie('old_user_country',oldcountrycode,-1);}}
	 
 }
 
 if((url=='https://www.scionintl.com/india/' && countrycode!='IN'))
 {
	  if(countrycode=='US'){ if(oldcountrycode!='US') {woocs_redirect_custom('USD') ; location.href='https://www.scionintl.com/usa/'; createCookie('old_user_country',oldcountrycode,-1);}}
	 if(countrycode=='AE'){if(oldcountrycode!='AE') {woocs_redirect_custom('AED') ; location.href='https://www.scionintl.com/uae/'; createCookie('old_user_country',oldcountrycode,-1);}}
 }
  if((url=='https://www.scionintl.com/uae/' && countrycode!='AE'))
 {
	  if(countrycode=='US'){ if(oldcountrycode!='US') {woocs_redirect_custom('USD') ; location.href='https://www.scionintl.com/usa/'; createCookie('old_user_country',oldcountrycode,-1);}}
	  if(countrycode=='IN'){
		 if(oldcountrycode!='IN') {woocs_redirect_custom('INR') ; location.href='https://www.scionintl.com/india/'; createCookie('old_user_country',oldcountrycode,-1);}
	     
	 }
 }
   if((url=='https://www.scionintl.com/usa/' && countrycode!='US'))
 {
	  if(countrycode=='AE'){if(oldcountrycode!='AE') {woocs_redirect_custom('AED') ; location.href='https://www.scionintl.com/uae/'; createCookie('old_user_country',oldcountrycode,-1);}}
	  if(countrycode=='IN'){
		 if(oldcountrycode!='IN') {woocs_redirect_custom('INR') ; location.href='https://www.scionintl.com/india/'; createCookie('old_user_country',oldcountrycode,-1);}
	     
	 }
 }
function createCookie(cookieName,cookieValue,daysToExpire)
        {
          var date = new Date();
          date.setTime(date.getTime()+(daysToExpire*24*60*60*1000));
          document.cookie = cookieName + "=" + cookieValue + "; expires=" + date.toGMTString() + ";path=/";
        }
 

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

$(".woof_container_inner_productcategories h4").click(function(){
  $("#mCSB_1").slideToggle();
});


</script>
</body>
</html>
