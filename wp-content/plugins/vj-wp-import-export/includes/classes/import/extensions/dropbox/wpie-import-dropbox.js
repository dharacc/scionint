"use strict";function wpieUploadDropboxFile(e){wpieSetProcessLoader({wpieDownloadFileText:wpiePluginSettings.wpieLocalizeText.wpieDownloadFileText});var i=e[0].link,t={action:"wpie_import_upload_file_from_dropbox",wpie_import_id:wpiePluginSettings.wpieImportId,file_url:i,wpieSecurity:wpiePluginSettings.wpieSecurity};jQuery.ajax({url:wpiePluginSettings.wpieAjaxURL,type:"POST",data:t,dataType:"json",async:!0,success:function(e){return wpieUpdateProcessLoader("wpieDownloadFileText"),"error"===e.status?(wpieSetErrorMsg(e.message),!1):void wpieSetFileData(e)},error:function(e,i){wpieHandleAjaxError(e,i)}})}window.wpiePluginSettings=window.wpiePluginSettings||{},window.Dropbox=window.Dropbox||{},jQuery(document).on("click",".wpie_dropbox_upload_btn",function(){var e=jQuery(".wpie_dropbox_app_key").val();if(""!==e){var i={success:function(e){wpieUploadDropboxFile(e)},cancel:function(){},linkType:"direct",multiselect:!1,extensions:[".zip",".json",".txt",".csv",".xml",".xls",".xlsx"],folderselect:!1};Dropbox.appKey=e,Dropbox.choose(i)}});