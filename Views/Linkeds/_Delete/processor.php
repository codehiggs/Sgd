<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2024-08-21 14:20:36
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sgd\Views\Linkeds\Editor\processor.php]
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
$bootstrap = service('Bootstrap');
$f = service("forms", array("lang" => "Linkeds."));
//$model = model("App\Modules\Sgd\Models\Sgd_Linkeds");
$pkey= $f->get_Value("pkey");
$row = $model->withDeleted()->find($pkey);
/* Vars */
$l["back"]="/sgd/linkeds/list/".lpk();
$l["edit"]="/sgd/linkeds/edit/{$pkey}";
$vsuccess="sgd/linkeds-delete-success-message.mp3";
$vnoexist="sgd/linkeds-delete-noexist-message.mp3";
/* Build */
if (isset($row["linked"])) {
   $delete=$model->delete($pkey);
   
    $c =$bootstrap->get_Card("duplicate", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Linkeds.delete-success-title"),
        "text-class" => "text-center",
        "text" => lang("Linkeds.delete-success-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $vsuccess,
    ));
}else {
    $c =$bootstrap->get_Card("success", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Linkeds.delete-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Linkeds.delete-noexist-message"),$d['linked']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $vnoexist,
    ));
}
echo($c);
?>
