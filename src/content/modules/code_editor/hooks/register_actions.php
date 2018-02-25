<?php
include_once ULICMS_ROOT . "/lib/formatter.php";
include_once getModulePath("code_editor", true) . "controller/code_editor_controller.php";

global $actions;
$actions["edit_code"] = getModulePath("code_editor", true) . "edit_code.php";
