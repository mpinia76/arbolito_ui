<?php
namespace Arbolito\UI\pages\tiposCliente\agregar;

use Arbolito\UI\pages\ArbolitoPage;

use Rasty\utils\XTemplate;
use Arbolito\Core\model\TipoCliente;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class TipoClienteAgregar extends ArbolitoPage{

	/**
	 * TipoCliente a agregar.
	 * @var TipoCliente
	 */
	private $TipoCliente;


	public function __construct(){

		//inicializamos el TipoCliente.
		$TipoCliente = new TipoCliente();

		//$TipoCliente->setNombre("Bernardo");
		//$TipoCliente->setEmail("ber@mail.com");
		$this->setTipoCliente($TipoCliente);


	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario
		//y utilizando permisos

		$menuGroup = new MenuGroup();

		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "form.volver") );
		$menuOption->setPageName("TiposCliente");
		$menuGroup->addMenuOption( $menuOption );


		return array($menuGroup);
	}

	public function getTitle(){
		return $this->localize( "tipoCliente.agregar.title" );
	}

	public function getType(){

		return "TipoClienteAgregar";

	}

	protected function parseXTemplate(XTemplate $xtpl){
		$tipoClienteForm = $this->getComponentById("tipoClienteForm");
		$tipoClienteForm->fillFromSaved( $this->getTipoCliente() );

	}


	public function getTipoCliente()
	{
	    return $this->TipoCliente;
	}

	public function setTipoCliente($TipoCliente)
	{
	    $this->TipoCliente = $TipoCliente;
	}



	public function getMsgError(){
		return "";
	}
}
?>
