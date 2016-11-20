<?php
define ( "MODULE_ADMIN_HEADLINE", get_translation ( "code_editor" ) );
define ( "MODULE_ADMIN_REQUIRED_PERMISSION", "code_editor" );
function code_editor_admin() {
	?>
<table class="tablesorter">
	<thead>
		<tr>
			<th>
<?php translate("file");?>
</th>
			<th>
<?php translate("last_changed");?>
</th>
			<th>
<?php translate("size");?>
</th>
			<td></td>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>
<?php
}
?>
