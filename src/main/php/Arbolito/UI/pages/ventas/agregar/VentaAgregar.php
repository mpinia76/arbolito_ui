<?php
namespace Arbolito\UI\pages\ventas\agregar;

use Arbolito\Core\utils\ArbolitoUtils;
use Arbolito\UI\utils\ArbolitoUIUtils;

use Arbolito\UI\pages\ArbolitoPage;

use Rasty\utils\XTemplate;
use Arbolito\Core\model\Venta;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

use Rasty\utils\RastyUtils;
use Arbolito\UI\service\UIServiceFactory;

class VentaAgregar extends ArbolitoPage{

	/**
	 * venta a agregar.
	 * @var Venta
	 */
	private $venta;


	public function __construct(){

		//inicializamos el venta.
		$venta = new Venta();

		$venta->setFecha( new \Datetime() );

		if(RastyUtils::getParamGET("clienteOid") ){
			$cliente = UIServiceFactory::getUIClienteService()->get( RastyUtils::getParamGET("clienteOid") );
			$venta->setCliente($cliente );
		}
		else{
			//$venta->setCliente( ArbolitoUtils::getClienteDefault() );
		}


		$this->setVenta($venta);


	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario
		//y utilizando permisos

		$menuGroup = new MenuGroup();

//		$menuOption = new MenuOption();
//		$menuOption->setLabel( $this->localize( "form.volver") );
//		$menuOption->setPageName("Ventas");
//		$menuGroup->addMenuOption( $menuOption );
//

		return array($menuGroup);
	}

	public function getTitle(){
		return $this->localize( "venta.agregar.title" );
	}

	public function getType(){

		return "VentaAgregar";

	}

	protected function parseXTemplate(XTemplate $xtpl){

		ArbolitoUIUtils::setDetallesVentaSession( array() );
		$ventaForm = $this->getComponentById("ventaForm");
		$ventaForm->fillFromSaved( $this->getVenta() );
	}


	public function getVenta()
	{
	    return $this->venta;
	}

	public function setVenta($venta)
	{
	    $this->venta = $venta;
	}



	public function getMsgError(){
		return "";
	}
}
?>
