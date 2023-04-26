"use strict";function wpieLoadPicker(){gapi.load("auth",{callback:wpieOnAuthApiLoad}),gapi.load("picker",{callback:wpieOnPickerApiLoad})}function wpieOnAuthApiLoad(){window.gapi.auth.authorize({client_id:pickerClientId,scope:pickerScope,immediate:!1},wpieHandleAuthResult)}function wpieOnPickerApiLoad(){pickerApiLoaded=!0,wpieCreatePicker()}function wpieHandleAuthResult(e){e&&!e.error&&(pickerOauthToken=e.access_token,wpieCreatePicker())}function wpieCreatePicker(){if(pickerApiLoaded&&pickerOauthToken){var e=(new google.picker.PickerBuilder).addViewGroup(new google.picker.ViewGroup(google.picker.ViewId.DOCS).addView(google.picker.ViewId.DOCUMENTS).addView(google.picker.ViewId.PRESENTATIONS)).setOAuthToken(pickerOauthToken).setDeveloperKey(pickerDeveloperKey).setCallback(wpiePickerCallback).build();e.setVisible(!0)}}function wpiePickerCallback(e){if(e[google.picker.Response.ACTION]===google.picker.Action.PICKED){wpieSetProcessLoader({wpieDownloadFileText:wpiePluginSettings.wpieLocalizeText.wpieDownloadFileText});var i=e[google.picker.Response.DOCUMENTS][0],t={action:"wpie_import_upload_file_from_googledrive",wpie_import_id:wpiePluginSettings.wpieImportId,fileId:i.id,oAuthToken:pickerOauthToken,name:i.name,wpieSecurity:wpiePluginSettings.wpieSecurity};jQuery.ajax({url:wpiePluginSettings.wpieAjaxURL,type:"POST",data:t,dataType:"json",async:!0,success:function(e){return wpieUpdateProcessLoader("wpieDownloadFileText"),"error"===e.status?(wpieSetErrorMsg(e.message),!1):void wpieSetFileData(e)},error:function(e,i){wpieHandleAjaxError(e,i)}})}}window.wpiePluginSettings=window.wpiePluginSettings||{},window.gapi=window.gapi||{},window.google=window.google||{};var pickerDeveloperKey="",pickerClientId="",pickerScope=["https://www.googleapis.com/auth/drive.readonly"],pickerApiLoaded=!1,pickerOauthToken;jQuery(document).on("click",".wpie_google_drive_upload_btn",function(){pickerDeveloperKey=jQuery(".wpie_gd_developer_key").val(),pickerClientId=jQuery(".wpie_gd_client_id").val(),""!==pickerClientId&&wpieLoadPicker()});