<?php

namespace App\Modules\Sgd\Controllers;

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2024-08-21 14:20:40
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sgd\Controllers\_Metatags.php]
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

use App\Controllers\ModuleController;

class Metatags extends ModuleController {

	//[Sgd/Config/Routes]
	//[Metatags]----------------------------------------------------------------------------------------
	//"sgd-metatags-home"=>"$views\Metatags\Home\index",
	//"sgd-metatags-list"=>"$views\Metatags\List\index",
	//"sgd-metatags-view"=>"$views\Metatags\View\index",
	//"sgd-metatags-create"=>"$views\Metatags\Create\index",
	//"sgd-metatags-edit"=>"$views\Metatags\Edit\index",
	//"sgd-metatags-delete"=>"$views\Metatags\Delete\index",

	//[Metatags]----------------------------------------------------------------------------------------
	//						"sgd-metatags-access",
	//						"sgd-metatags-view",
	//						"sgd-metatags-view-all",
	//						"sgd-metatags-create",
	//						"sgd-metatags-edit",
	//						"sgd-metatags-edit-all",
	//						"sgd-metatags-delete",
	//						"sgd-metatags-delete-all",

    public function __construct() {
       parent::__construct();
       $this->prefix = 'sgd-metatags';
       $this->module = 'App\Modules\Sgd';
       $this->views = $this->module . '\Views';
       $this->viewer = $this->views . '\index';
       helper($this->module.'\Helpers\Sgd');
    }

    public function index() {
        $url = base_url('sgd/metatags/home/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd) {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Metatags\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function view(string $oid) {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-view";
        $this->component = $this->views . '\Metatags\View';
        return (view($this->viewer, $this->get_Array()));
    }

    public function list(string $rnd) {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-list";
        $this->component = $this->views . '\Metatags\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd) {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-create";
        $this->component = $this->views . '\Metatags\Create';
        return (view($this->viewer, $this->get_Array()));
    }

    public function edit(string $oid) {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-edit";
        $this->component = $this->views . '\Metatags\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

    public function delete(string $oid) {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-delete";
        $this->component = $this->views . '\Metatags\Delete';
        return (view($this->viewer, $this->get_Array()));
    }


}
?>