<form method="post" action="">
  <?php if( function_exists( 'wp_nonce_field' )) wp_nonce_field( 'piereg_wp_invitation_code_nonce','piereg_invitation_code_nonce'); ?>
  <ul class="bg-white clearfix invite-form">
      <?php if(!$this->piereg_pro_is_activate ){ ?>
          <h3 class="inactive-promessage"><?php _e("Available in premium version","pie-register");?></h3>
       <?php }?>
        <li class="clearfix">
        <div class="fields">
          <div  class="cols-2">
            <h3>
              <?php _e("Code Prefix","pie-register");?>
            </h3>
          </div><!-- cols-3 -->
         <div class="cols-3">
          <?php if($this->piereg_pro_is_activate ){ ?>
            <input style="float:left;" value="<?php echo (isset($this->pie_post_array['invitation_code_prefix'])?$this->pie_post_array['invitation_code_prefix']:''); ?>" maxlength="3" type="text" name="invitation_code_prefix" id="invitation_code_prefix" class="input_fields2"/>
            <span style="text-align:left;" class="note pie_usage_note">
            <?php _e("Prefix should contain atleast 3 characters (alphabets/numbers).","pie-register");?>
            </span>
          <?php } else { ?> 
            <input style="float:left;" type="text" name="invitation_code_prefix" id="invitation_code_prefix" class="input_fields2" disabled="" />
            <span style="text-align:left;" class="note pie_usage_note">
            <?php _e("Prefix should contain atleast 3 characters (alphabets/numbers).","pie-register");?>
            </span>
          <?php }?> 
          </div><!-- cols-3 -->
        </div>
      </li>
      <li class="clearfix">
        <div class="fields">
          <div  class="cols-2">
            <h3>
              <?php _e("Code Numbers","pie-register");?>
            </h3>
          </div><!-- cols-3 -->
         <div class="cols-3">
          <?php if($this->piereg_pro_is_activate ){ ?>
            <input style="float:left;" value="<?php echo (isset($this->pie_post_array['invitation_code_numbers'])?$this->pie_post_array['invitation_code_numbers']:''); ?>" type="number" min="1" max="10" name="invitation_code_numbers" class="input_fields2"/>
            <span style="text-align:left;" class="note pie_usage_note">
            <?php _e("Enter the number of codes to generate. Max 10","pie-register");?>
            </span>
          <?php } else { ?> 
             <input style="float:left;" type="number" name="invitation_code_numbers" class="input_fields2" disabled="" />
            <span style="text-align:left;" class="note pie_usage_note">
            <?php _e("Enter the number of codes to generate. Max 10","pie-register");?>
            </span>
          <?php }?> 
          </div><!-- cols-3 -->
        </div>
      </li>
      <li class="clearfix code_usageItem">
        <div class="fields">
          <div class="cols-2">
            <h3>
              <?php _e("Usage","pie-register");?>
            </h3>
          </div><!-- cols-3 -->
          <div class="cols-3">
            <?php if($this->piereg_pro_is_activate ){ ?>
            <input style="float:left;" value="<?php echo (isset($this->pie_post_array['invitation_code_usage'])?$this->pie_post_array['invitation_code_usage']:''); ?>" type="text" id="invitation_code_usage" name="invitation_code_usage" class="input_fields2" />
            <?php } else { ?>
              <input type="text" id="invitation_code_usage" name="invitation_code_usage" class="input_fields2" disabled />  
            <?php }  ?>
            <span style="text-align:left;" class="note pie_usage_note">
            <?php _e("Number of times a single code can be used to register.","pie-register");?>
            </span>
          </div><!-- cols-3 -->
           </div>
      </li>
      <li class="clearfix code_expiryDate">
        <div class="fields">
          <div class="cols-2">
            <h3>
              <?php _e("Expiry Date","pie-register");?>
            </h3>
          </div><!-- cols-3 -->
          <div class="cols-3">
            <?php if($this->piereg_pro_is_activate ){ ?>
              <?php 
                if(isset($this->pie_post_array['invitation_expiry_date'])){
                    $expiry = strtotime($this->pie_post_array['invitation_expiry_date']);
                    $dateNow = strtotime('now');
                    if($expiry < $dateNow){
                      $expiry = 'YYYY-MM-DD';  
                    } else {
                      $expiry = $this->pie_post_array['invitation_expiry_date'];  
                    }
                } else {
                    $expiry = 'YYYY-MM-DD';
                }

               ?>
              <input style="float:left;" autocomplete="off" value="<?php echo $expiry; ?>" type="text" name="invitation_expiry_date" class="input_fields2 expiry_datepicker date_start">
              <span style="text-align:left;" class="note pie_usage_note" style="color:red;">
                    <?php _e("Define invitation code expiry date here. Leaving it empty means that the invitation code will never expire.","pie-register");?>
                </span>
            <?php } else { ?>
                <input style="float:left;" autocomplete="off" value="YYYY-MM-DD" type="text" id="invitation_expiry_date" class="input_fields2" disabled="">
                <span style="text-align:left;" class="note pie_usage_note" style="color:red;">
                    <?php _e("Define invitation code expiry date here. Leaving it empty means that the invitation code will never expire. (Available in premium version.)","pie-register");?>
                </span>
            <?php } ?>
          </div><!-- cols-3 -->
           </div>
      </li>
    
    <li class="clearfix">
      <div class="fields fields_submitbtn">
        <div class="cols-2">&nbsp;</div><!-- cols-3 -->
        <div class="cols-3 text-right">
          <input name="add_code" class="submit_btn" value="<?php _e('Add Code','pie-register');?>" type="submit" />
        </div><!-- cols-3 -->
      </div>
    </li>

  </ul>
</form>
