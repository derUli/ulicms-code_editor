<?php
include_once ULICMS_ROOT . "/classes/objects/path.php";
include_once ULICMS_ROOT . "/lib/formatter.php";
include_once getModulePath ( "code_editor" ) . "controller/code_editor_controller.php";

global $actions;
$actions ["edit_code"] = getModulePath ( "code_editor" ) . "edit_code.php";
