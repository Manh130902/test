<?php
if ( ! defined( 'ABSPATH' ) ) {
     exit;
 }                                           
$name=$this->post('name',$info);     
 ?>
  <div class="crm_fields_table">
    <div class="crm_field">
  <div class="crm_field_cell1"><label for="vx_name"><?php esc_html_e("Account Name",'gravity-forms-zoho-crm'); ?></label>
  </div>
  <div class="crm_field_cell2">
  <input type="text" name="crm[name]" value="<?php echo !empty($name) ? esc_attr($name) : 'Account #'.esc_attr($id); ?>" id="vx_name" class="crm_text">

  </div>
  <div class="clear"></div>
  </div>
  
    <div class="crm_field">
  <div class="crm_field_cell1">
  <label for="vx_dc"><?php esc_html_e('Data Center','gravity-forms-zoho-crm'); ?></label>
  </div>
  <div class="crm_field_cell2">
<select name="crm[dc]" class="crm_text" id="vx_dc" data-save="no" <?php if( !empty($info['access_token'])){ echo 'disabled="disabled"'; } ?> >
  <?php $envs=array(
  'com'=>__('zoho.com (Global - USA)','gravity-forms-zoho-crm'),
  'eu'=>__('zoho.eu (Europe)','gravity-forms-zoho-crm'),
  'in'=>__('zoho.in (India)','gravity-forms-zoho-crm'),
  'com.cn'=>__('zoho.com.cn (China)','gravity-forms-zoho-crm'),
  'com.au'=>__('zoho.com.au (Australia)','gravity-forms-zoho-crm'),
      'jp'=>__('zoho.jp (Japan)','gravity-forms-zoho-crm'),
  'uk'=>__('zoho.uk (United Kingdom)','gravity-forms-zoho-crm'),
  'ca'=>__('zohocloud.ca (Canada)','gravity-forms-zoho-crm'),
   'sa'=>__('zoho.sa (KSA)','gravity-forms-zoho-crm'),
  );
foreach($envs as $k=>$v){
    $sel='';
if(!empty($info['dc']) && $info['dc'] == $k){ $sel='selected="selected"'; }
echo '<option value="'.esc_attr($k).'" '.$sel.'>'.esc_html($v).'</option>';
}
 ?>
 </select>
  </div>
  <div class="clear"></div>
  </div>
  
    <div class="crm_field">
  <div class="crm_field_cell1">
  <label for="vx_type"><?php esc_html_e('Zoho Service','gravity-forms-zoho-crm'); ?></label>
  </div>
  <div class="crm_field_cell2">
<select name="crm[type]" class="crm_text" id="vx_type" <?php if( !empty($info['access_token'])){ echo 'disabled="disabled"'; } ?> >
  <?php $envs=array(
  ''=>__('Zoho CRM','gravity-forms-zoho-crm'),
  'bigin'=>__('Zoho Begin','gravity-forms-zoho-crm')
  );
foreach($envs as $k=>$v){
    $sel='';
if(!empty($info['type']) && $info['type'] == $k){ $sel='selected="selected"'; }
echo '<option value="'.$k.'" '.$sel.'>'.$v.'</option>';
}
 ?>
 </select>
  </div>
  <div class="clear"></div>
  </div>
   
  
  <script type="text/javascript">
  jQuery(document).ready(function($){
  /*  $('#vx_dc').change(function(){
        var val=$(this).val();
        var btn=$('.sf_login');
      var url='https://accounts.zoho.'+val+'/';
      var dc=btn.attr('data-url');  
  btn.attr('href',url+dc); 
    })*/
    var elem=$('#mainform');
    var form=elem.serialize();
      $('.sf_login').click(function(e){
      var form2=elem.serialize(); 
      if(form != form2){
         e.preventDefault();
        alert('Please "Save Changes" first');  
      }
      });  
  })
  </script>
<div class="crm_field">
  <div class="crm_field_cell1"><label><?php esc_html_e('Zoho Access','gravity-forms-zoho-crm'); ?></label></div>
  <div class="crm_field_cell2">
  <?php if(isset($info['access_token'])  && $info['access_token']!="") {
  ?>
  <div style="padding-bottom: 8px;" class="vx_green"><i class="fa fa-check"></i> <?php
  echo sprintf(__("Authorized Connection to %s on %s",'gravity-forms-zoho-crm'),'<code>Zoho</code>',date('F d, Y h:i:s A',$info['_time']));
?></div><?php
  }else{
      $ret=esc_url($link).'&'.$this->id."_tab_action=get_token&vx_action=redirect&id=".$id."&vx_nonce=".$nonce;
$dc=!empty($info['dc']) ? esc_html($info['dc']) : 'com';
$ret_dc=$ret.'&dc='.$dc; //,ZohoCRM.files.read
$scope='ZohoCRM.modules.ALL,ZohoCRM.settings.ALL,ZohoCRM.users.Read,ZohoCRM.coql.READ,ZohoCRM.files.CREATE,ZohoCRM.files.READ';
if(!empty($info['type'])){
    if($info['type'] == 'bigin'){
$scope='ZohoBigin.modules.ALL,ZohoBigin.settings.ALL,ZohoBigin.users.Read';
} 
}
$auth_url='oauth/v2/auth?scope='.$scope.'&response_type=code&client_id='.esc_html($client['client_id']).'&access_type=offline&redirect_uri='.urlencode(esc_url($client['call_back']));

$ac_url=$api->ac_url();      
?>
  <a class="button button-default button-hero sf_login" data-id="<?php echo esc_html($client['client_id']) ?>" href="<?php echo $ac_url.$auth_url.'&state='.urlencode($ret_dc) ?>"  data-state="<?php echo urlencode($ret); ?>" data-url="<?php echo $auth_url ?>"  title="<?php esc_html_e("Login with Zoho",'gravity-forms-zoho-crm'); ?>" > <i class="fa fa-lock"></i> <?php esc_html_e("Login with Zoho",'gravity-forms-zoho-crm'); ?></a><?php } ?>
  </div>
  <div class="clear"></div>
  </div>                  
<?php if(isset($info['access_token'])  && $info['access_token']!="") { ?>
<div class="crm_field">
  <div class="crm_field_cell1"><label><?php esc_html_e("Revoke Access",'gravity-forms-zoho-crm'); ?></label></div>
  <div class="crm_field_cell2">  <a class="button button-secondary" id="vx_revoke" href="<?php echo esc_url($link."&".$this->id."_tab_action=get_token&vx_nonce=".$nonce.'&id='.$id)?>"><i class="fa fa-unlock"></i> <?php esc_html_e("Revoke Access",'gravity-forms-zoho-crm'); ?></a>
  </div>
  <div class="clear"></div>
  </div> 
<?php } ?>
 
   <div class="crm_field">
  <div class="crm_field_cell1">
  <label for="vx_custom_app_check"><?php esc_html_e("Zoho Client",'gravity-forms-zoho-crm'); ?></label>
  </div>
  <div class="crm_field_cell2"><div><label for="vx_custom_app_check">
  <input type="checkbox" name="crm[custom_app]" id="vx_custom_app_check" style="margin-right: 5px; vertical-align: baseline" value="yes" <?php if($this->post('custom_app',$info) == "yes"){echo 'checked="checked"';} ?>><?php echo esc_html__('Use Own Zoho App - If you want to connect one Zoho account to multiple sites then use a separate Zoho App for each site ','gravity-forms-zoho-crm'); ?></label></div>
  </div>
  <div class="clear"></div>
  </div>
  

<div id="vx_custom_app_div" style="<?php if($this->post('custom_app',$info) != "yes"){echo 'display:none';} ?>">
     <div class="crm_field">
  <div class="crm_field_cell1"><label for="app_id"><?php esc_html_e("Client ID",'gravity-forms-zoho-crm'); ?></label></div>
  <div class="crm_field_cell2">
     <div class="vx_tr">
  <div class="vx_td">
  <input type="password" id="app_id" name="crm[app_id]" class="crm_text" placeholder="<?php esc_html_e("Zoho Client ID",'gravity-forms-zoho-crm'); ?>" value="<?php echo esc_html($this->post('app_id',$info)); ?>">
  </div><div class="vx_td2">
  <a href="#" class="button vx_toggle_btn vx_toggle_key" title="<?php esc_html_e('Toggle Consumer Key','gravity-forms-zoho-crm'); ?>"><?php esc_html_e('Show Key','gravity-forms-zoho-crm') ?></a>
  
  </div></div>
  
    <div class="howto">
  <ol>
  <li><?php echo sprintf(__('Create New Client %shere%s','gravity-forms-zoho-crm'),'<a href="https://accounts.zoho.com/developerconsole" target="_blank">','</a>'); ?></li>
  <li><?php esc_html_e('Enter Client Name(eg. My App)','gravity-forms-zoho-crm'); ?></li>
  <li><?php echo sprintf(__('Enter %s or %s in Redirect URI','gravity-forms-zoho-crm'),'<code>https://www.crmperks.com/google_auth/</code>','<code>'.$link."&".$this->id.'_tab_action=get_code</code>'); ?>
  </li>
<li><?php esc_html_e('Select Client Type as "Web Based"','gravity-forms-zoho-crm'); ?></li>
<li><?php esc_html_e('Save Application','gravity-forms-zoho-crm'); ?></li>
<li><?php echo esc_html__('Copy Client Id and Secret','gravity-forms-zoho-crm'); ?></li>
   </ol>
  </div>
  
</div>
  <div class="clear"></div>
  </div>
     <div class="crm_field">
  <div class="crm_field_cell1"><label for="app_secret"><?php esc_html_e("Client Secret",'gravity-forms-zoho-crm'); ?></label></div>
  <div class="crm_field_cell2">
       <div class="vx_tr" >
  <div class="vx_td">
 <input type="password" id="app_secret" name="crm[app_secret]" class="crm_text"  placeholder="<?php esc_html_e("Zoho Client Secret",'gravity-forms-zoho-crm'); ?>" value="<?php echo esc_html($this->post('app_secret',$info)); ?>">
  </div><div class="vx_td2">
  <a href="#" class="button vx_toggle_btn vx_toggle_key" title="<?php esc_html_e('Toggle Consumer Secret','gravity-forms-zoho-crm'); ?>"><?php esc_html_e('Show Key','gravity-forms-zoho-crm') ?></a>
  
  </div></div>
  </div>
  <div class="clear"></div>
  </div>
       <div class="crm_field">
  <div class="crm_field_cell1"><label for="app_url"><?php esc_html_e("Zoho Client Redirect URL",'gravity-forms-zoho-crm'); ?></label></div>
  <div class="crm_field_cell2"><input type="text" id="app_url" name="crm[app_url]" class="crm_text" placeholder="<?php esc_html_e("Zoho Client Redirect URL",'gravity-forms-zoho-crm'); ?>" value="<?php echo esc_html($this->post('app_url',$info)); ?>"> 

  </div>
  <div class="clear"></div>
  </div>
  </div>

 <div class="crm_field">
  <div class="crm_field_cell1"><label><?php esc_html_e("Test Connection",'gravity-forms-zoho-crm'); ?></label></div>
  <div class="crm_field_cell2">      <button type="submit" class="button button-secondary" name="vx_test_connection"><i class="fa fa-refresh"></i> <?php esc_html_e("Test Connection",'gravity-forms-zoho-crm'); ?></button>
  </div>
  <div class="clear"></div>
  </div>
  
  <div class="crm_field">
  <div class="crm_field_cell1"><label for="vx_error_email"><?php esc_html_e("Notify by Email on Errors",'gravity-forms-zoho-crm'); ?></label></div>
  <div class="crm_field_cell2"><textarea name="crm[error_email]" id="vx_error_email" placeholder="<?php esc_html_e("Enter comma separated email addresses",'gravity-forms-zoho-crm'); ?>" class="crm_text" style="height: 70px"><?php echo isset($info['error_email']) ? esc_html($info['error_email']) : ""; ?></textarea>
  <span class="howto"><?php esc_html_e("Enter comma separated email addresses. An email will be sent to these email addresses if an order is not properly added to Zoho. Leave blank to disable.",'gravity-forms-zoho-crm'); ?></span>
  </div>
  <div class="clear"></div>
  </div>  
   
  
  
   <div class="crm_field">
  <div class="crm_field_cell1"><label for="vx_cache">
  <?php esc_html_e("Remote Cache Time", 'gravity-forms-zoho-crm'); ?>
  </label>
 </div>
 <div class="crm_field_cell2">
    <div style="display: table">
  <div style="display: table-cell; width: 85%;">
  <select id="vx_cache" name="crm[cache_time]" style="width: 100%">
  <?php
  $cache=array("60"=>"One Minute (for testing only)","3600"=>"One Hour","21600"=>"Six Hours","43200"=>"12 Hours","86400"=>"One Day","172800"=>"2 Days","259200"=>"3 Days","432000"=>"5 Days","604800"=>"7 Days","18144000"=>"1 Month");
  if($this->post('cache_time',$info) == ""){
   $info['cache_time']="86400";
  }
  foreach($cache as $secs=>$label){
   $sel="";
   if($this->post('cache_time',$info) == $secs){
       $sel='selected="selected"';
   }
  echo '<option value="'.esc_attr($secs).'" '.$sel.' >'.esc_html($label).'</option>';     
  }   
  ?>
  </select></div><div style="display: table-cell;">
  <button name="vx_tab_action" value="refresh_lists_<?php echo esc_attr($this->id) ?>" class="button" style="margin-left: 10px; vertical-align: baseline; width: 110px" autocomplete="off" title="<?php esc_html_e('Refresh Picklists','gravity-forms-zoho-crm'); ?>">Refresh Now</button>
  </div></div>
  <span class="howto">
  <?php esc_html_e("How long should form and field data be stored? This affects how often remote picklists will be checked for the Live Remote Field Mapping feature. This is an advanced setting. You likely won't need to change this.",'gravity-forms-zoho-crm'); ?>
  </span></div>
  </div>
  

<p class="submit">
  <button type="submit" value="save" class="button-primary" title="<?php esc_html_e('Save Changes','gravity-forms-zoho-crm'); ?>" name="save"><?php esc_html_e('Save Changes','gravity-forms-zoho-crm'); ?></button></p>  
  </div>  

 