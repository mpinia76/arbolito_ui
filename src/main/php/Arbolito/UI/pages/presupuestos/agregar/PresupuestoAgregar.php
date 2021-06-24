<?php
namespace Arbolito\UI\pages\presupuestos\agregar;

use Arbolito\Core\utils\ArbolitoUtils;
use Arbolito\UI\utils\ArbolitoUIUtils;

use Arbolito\UI\pages\ArbolitoPage;

use Rasty\utils\XTemplate;
use Arbolito\Core\model\Presupuesto;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class PresupuestoAgregar extends ArbolitoPage{

	/**
	 * presupuesto a agregar.
	 * @var Presupuesto
	 */
	private $presupuesto;


	public function __construct(){

		//inicializamos el presupuesto.
		$presupuesto = new Presupuesto();

		$presupuesto->setFecha( new \Datetime() );

		$presupuesto->setCliente( ArbolitoUtils::getClienteDefault() );

		$this->setPresupuesto($presupuesto);


	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario
		//y utilizando permisos

		$menuGroup = new MenuGroup();

//		$menuOption = new MenuOption();
//		$menuOption->setLabel( $this->localize( "form.volver") );
//		$menuOption->setPageName("Presupuestos");
//		$menuGroup->addMenuOption( $menuOption );
//

		return array($menuGroup);
	}

	public function getTitle(){
		return $this->localize( "presupuesto.agregar.title" );
	}

	public function getType(){

		return "PresupuestoAgregar";

	}

	protected function parseXTemplate(XTemplate $xtpl){

		ArbolitoUIUtils::setDetallesPresupuestoSession( array() );
	}


	public function getPresupuesto()
	{
	    return $this->presupuesto;
	}

	public function setPresupuesto($presupuesto)
	{
	    $this->presupuesto = $presupuesto;
	}



	public function getMsgError(){
		return "";
	}
}
?>
