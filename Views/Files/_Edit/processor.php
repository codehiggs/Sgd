<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2024-08-21 14:20:21
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sgd\Views\Files\Editor\processor.php]
* █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
* █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
* █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
* █ ---------------------------------------------------------------------------------------------------------------------
* █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
* █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
* █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
* █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
* █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
* █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
* █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
* █ ---------------------------------------------------------------------------------------------------------------------
* █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
* █ @link https://www.codehiggs.com
* █ @Version 1.5.0 @since PHP 7, PHP 8
* █ ---------------------------------------------------------------------------------------------------------------------
* █ Datos recibidos desde el controlador - @ModuleController
* █ ---------------------------------------------------------------------------------------------------------------------
* █ @var object $parent Trasferido desde el controlador
* █ @var object $authentication Trasferido desde el controlador
* █ @var object $request Trasferido desde el controlador
* █ @var object $dates Trasferido desde el controlador
* █ @var string $component Trasferido desde el controlador
* █ @var string $view Trasferido desde el controlador
* █ @var string $oid Trasferido desde el controlador
* █ @var string $views Trasferido desde el controlador
* █ @var string $prefix Trasferido desde el controlador
* █ @var array $data Trasferido desde el controlador
* █ @var object $model Modelo de datos utilizado en la vista y trasferido desde el index
* █ ---------------------------------------------------------------------------------------------------------------------
**/
//[Services]-----------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication =service('authentication');
//[services]------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sgd\Models\Sgd_Files");
//[Process]-----------------------------------------------------------------------------
$f = service("forms",array("lang" => "Files."));
$d = array(
    "file" => $f->get_Value("file"),
    "name" => $f->get_Value("name"),
    "description" => $f->get_Value("description"),
    "author" => safe_get_user(),
    "size" => $f->get_Value("size"),
    "type" => $f->get_Value("type"),
    "url" => $f->get_Value("url"),
);
//[Elements]-----------------------------------------------------------------------------
$row = $model->find($d["file"]);
$l["back"]="/sgd/files/list/".lpk();
$l["edit"]="/sgd/files/edit/{$d["file"]}";
$asuccess = "sgd/files-edit-success-message.mp3";
$anoexist = "sgd/files-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
   $edit = $model->update($d['file'],$d);
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Files.edit-success-title"),
        "text-class" => "text-center",
        "text" => lang("Files.edit-success-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
} else {
    $create = $model->insert($d);
    //echo($model->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("warning", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Files.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Files.edit-noexist-message"),$d['file']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
?>
