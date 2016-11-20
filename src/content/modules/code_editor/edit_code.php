<?php
$file = $_REQUEST ["file"];
$acl = new ACL ();
$controller = new CodeEditorController ();
if ($acl->hasPermission ( "code_editor" ) and in_array ( $file, $_SESSION ["editable_code_files"] )) {
	$absPath = ULICMS_ROOT . $file;
	if (isset ( $_REQUEST ["save"] ) and isset ( $_POST ["data"] )) {
		file_put_contents ( $absPath, $_POST ["data"] );
	}
	$data = file_get_contents ( $absPath );
	?>
<p>
	<strong><?php Template::escape($file);?></strong>
</p>
<?php if($data){?>
<form
	action="index.php?action=edit_code&file=<?php Template::escape($file);?>&save"
	method="post" id="code-form">
<?php csrf_token_html();?>
<p>
		<textarea id="data" name="data" cols="20" rows="80"><?php Template::escape($data);?></textarea>
	</p>
	<p>
		<input type="submit" value="<?php translate("save_changes");?>">
	
	
	<div class="inPageMessage">
		<div id="msg_code_edit" class="inPageMessage"></div>
		<img class="loading" src="gfx/loading.gif" alt="Wird gespeichert...">
	</div>
</form>
<script type="text/javascript">
$(document).ready(function(){
var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("data"),

		{lineNumbers: true,
		        matchBrackets: true,
		        mode : "<?php echo $controller->getMimeTypeForFile($file);?>",

		        indentUnit: 0,
		        indentWithTabs: false,
		        enterMode: "keep",
		        tabMode: "shift"});

$("#code-form").ajaxForm({beforeSubmit: function(e){
	  $("#msg_code_edit").html("");
	  $("#msg_code_edit").hide();
	  $(".loading").show();
	  }, beforeSerialize:function($Form, options){
	        /* Before serialize */
	        for ( instance in CKEDITOR.instances ) {
	            CKEDITOR.instances[instance].updateElement();
	        }
	        return true;
	    },
	  success:function(e){
	  $(".loading").hide();
	  $("#msg_code_edit").html("<span style=\"color:green;\"><?php translate("x_saved");?></span>");
	  $("#msg_code_edit").show();
	  }

	});
	
});
        </script>
<?php }?>
<?php
} else {
	noperms ();
}