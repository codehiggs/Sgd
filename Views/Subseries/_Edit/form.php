<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2024-08-21 14:21:09
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sgd\Views\Subseries\Editor\form.php]
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
//[services]------------------------------------------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication =service('authentication');
$f = service("forms",array("lang" => "Subseries."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sgd\Models\Sgd_Subseries");
//[vars]----------------------------------------------------------------------------------------------------------------
$row= $model->get_Subseries($oid);
$r["subserie"] = $f->get_Value("subserie",$row["subserie"]);
$r["serie"] = $f->get_Value("serie",$row["serie"]);
$r["name"] = $f->get_Value("name",$row["name"]);
$r["description"] = $f->get_Value("description",$row["description"]);
$r["author"] = $f->get_Value("author",safe_get_user());
$r["created_at"] = $f->get_Value("created_at",$row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at",$row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at",$row["deleted_at"]);
$back= "/sgd/subseries/list/".lpk();
//[fields]----------------------------------------------------------------------------------------------------------------
$f->fields["subserie"] = $f->get_FieldText("subserie", array("value" => $r["subserie"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["serie"] = $f->get_FieldText("serie", array("value" => $r["serie"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["name"] = $f->get_FieldText("name", array("value" => $r["name"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["description"] = $f->get_FieldText("description", array("value" => $r["description"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author",$r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"]=$f->get_Cancel("cancel", array("href" =>$back,"text" =>lang("App.Cancel"),"type"=>"secondary","proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] =$f->get_Submit("submit", array("value" =>lang("App.Edit"),"proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["subserie"].$f->fields["serie"].$f->fields["name"])));
$f->groups["g2"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["description"].$f->fields["author"].$f->fields["created_at"])));
$f->groups["g3"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["updated_at"].$f->fields["deleted_at"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] =$f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields"=>$f->fields["submit"].$f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
		 "title" => lang("Subseries.edit-title"),
		 "content" =>$f,
		 "header-back" =>$back
));
echo($card);
?>
