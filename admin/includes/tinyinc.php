<?php
/*
  CourseMS
  https://sourceforge.net/projects/coursems

  Copyright (c) 2007 Jacques Malan

  This version of the code is released under the GNU General Public License
*/
?>
<script language="javascript" type="text/javascript" src="includes/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	plugins : "style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,flash,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable",
	theme_advanced_buttons1_add_before : "save,newdocument,separator",
	theme_advanced_buttons1_add : "fontselect,fontsizeselect",
	theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,separator,forecolor,backcolor",
	theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
	theme_advanced_buttons3_add_before : "tablecontrols,separator",
	theme_advanced_buttons3_add : "emotions,iespell,flash,advhr,separator,print,separator,ltr,rtl,separator,fullscreen",
	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_path_location : "bottom",
	content_css : "example_full.css",
	plugin_insertdate_dateFormat : "%Y-%m-%d",
	 plugin_insertdate_timeFormat : "%H:%M:%S",
	extended_valid_elements : "hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	external_link_list_url : "example_link_list.js",
	external_image_list_url : "example_image_list.js",
	flash_external_list_url : "example_flash_list.js",
	file_browser_callback : "fileBrowserCallBack",
	theme_advanced_resize_horizontal : false,
	theme_advanced_resizing : true
});
</script>
<?php
?>