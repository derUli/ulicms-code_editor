<?php

use UliCMS\Constants\RequestMethod;

$file = $_REQUEST["file"];
$controller = ControllerRegistry::get();
$absPath = ULICMS_DATA_STORAGE_ROOT . $file;
$data = file_get_contents($absPath);

if ($controller->canEditFile($file)) {
    ?>
    <p><a href="<?php echo ModuleHelper::buildAdminUrl("code_editor"); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> <?php translate("back"); ?></a></p>
    <p>
        <strong><?php Template::escape($file); ?></strong>
    </p>
    <?php
    if ($data) {
        echo ModuleHelper::buildMethodCallForm(
            CodeEditorController::class,
            "save",
            ["file" => $file],
            RequestMethod::POST,
            ["id" => "code-form"]
        ); ?>
        <p>
            <textarea id="data" name="data" cols="20" rows= "80" class="codemirror" data-mimetype="<?php esc($controller->getMimeTypeForFile($file)); ?>"><?php Template::escape($data); ?></textarea>
        </p>
        <p>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <?php translate("save_changes"); ?></button>
        </p>


        <div class="inPageMessage">
            <div id="msg_code_edit" class="inPageMessage"></div>
            <img class="loading" src="gfx/loading.gif" alt="Wird gespeichert...">
        </div>
        <?php
        echo ModuleHelper::endForm();

        $translation = new JSTranslation();
        $translation->addKey("changes_was_saved");
        $translation->render();

        BackendHelper::enqueueEditorScripts();
        enqueueScriptFile(ModuleHelper::buildRessourcePath("code_editor", "js/main.js"));
        combinedScriptHtml();
    }
} else {
    noperms();
}
