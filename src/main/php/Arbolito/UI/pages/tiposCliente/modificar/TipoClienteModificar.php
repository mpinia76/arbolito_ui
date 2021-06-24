<?php
namespace Arbolito\UI\pages\tiposCliente\modificar;

use Arbolito\UI\pages\ArbolitoPage;

use Arbolito\UI\service\UIServiceFactory;

use Rasty\utils\XTemplate;
use Arbolito\Core\model\TipoCliente;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class TipoClienteModificar extends ArbolitoPage{

	/**
	 * tipoCliente a modificar.
	 * @var TipoCliente
	 */
	private $tipoCliente;


	public function __construct(){

		//inicializamos el tipoCliente.
		$tipoCliente = new TipoCliente();
		$this->setTipoCliente($tipoCliente);

	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario
		//y utilizando permisos

		$menuGroup = new MenuGroup();

		return array($menuGroup);
	}

	public function setTipoClienteOid($oid){

		//a partir del id buscamos el tipoCliente a modificar.
		$tipoCliente = UIServiceFactory::getUITipoClienteService()->get($oid);

		$this->setTipoCliente($tipoCliente);

	}

	public function getTitle(){
		return $this->localize( "tipoCliente.modificar.title" );
	}

	public function getType(){

		return "TipoClienteModificar";

	}

	protected function parseXTemplate(XTemplate $xtpl){

	}

	public function getTipoCliente(){

	    return $this->tipoCliente;
	}

	public function setTipoCliente($tipoCliente)
	{
	    $this->tipoCliente = $tipoCliente;
	}
}
?>
