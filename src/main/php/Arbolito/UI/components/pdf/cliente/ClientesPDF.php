<?php

namespace Arbolito\UI\components\pdf\cliente;

use Datetime;
use Arbolito\UI\utils\ArbolitoUIUtils;

use Arbolito\UI\service\UIServiceFactory;

use Rasty\components\RastyComponent;
use Rasty\utils\RastyUtils;

use Rasty\utils\XTemplate;

use Arbolito\UI\components\filter\model\UIClienteCriteria;



use Rasty\utils\LinkBuilder;
use Rasty\render\DOMPDFRenderer;
use Rasty\conf\RastyConfig;
use Rasty\factory\PageFactory;

use Rasty\utils\Logger;


/**
 * para renderizar en pdf listado de clientes.
 *
 * @author Marcos
 * @since 25-06-2021
 *
 */
class ClientesPDF extends RastyComponent{



	public function getType(){

		return "ClientesPDF";

	}

	public function __construct(){


	}


	protected function parseXTemplate(XTemplate $xtpl){

		$page = PageFactory::build("Clientes");

		$clienteCriteria = new UIClienteCriteria();

		$clienteFilter = $page->getComponentById("clientesFilter");

		$clienteFilter->fillFromSaved($clienteCriteria);
		$xtpl->assign( "APP_PATH", RastyConfig::getInstance()->getAppPath() );
		$xtpl->assign( "fecha", ArbolitoUIUtils::formatDateTimeToView(new Datetime()) );




		$xtpl->assign("lbl_nroSocio", $this->localize( "cliente.nroSocio" ) );
        $xtpl->assign("lbl_cliente", $this->localize( "cliente.nombre" ) );
        $xtpl->assign("lbl_tipoCliente", $this->localize( "cliente.tipoCliente" ) );
        $xtpl->assign("lbl_documento", $this->localize( "cliente.documento" ) );
        $xtpl->assign("lbl_telefono", $this->localize( "cliente.telefono" ) );
        $xtpl->assign("lbl_domicilio", $this->localize( "cliente.direccion" ) );
        $xtpl->assign("lbl_nacimiento", $this->localize( "cliente.nacimiento" ) );




        $clientes = UIServiceFactory::getUIClienteService()->getList($clienteCriteria);
        //print_r($clientes);
        foreach ($clientes as $cliente) {


            $xtpl->assign( "nroSocio", $cliente->getNroSocio() );
            $xtpl->assign( "cliente", $cliente->getNombre() );
            $xtpl->assign( "tipoCliente", $cliente->getTipoCliente() );
            $xtpl->assign( "documento", $cliente->getDocumento() );
            $xtpl->assign( "telefono", $cliente->getTelefono() );
            $xtpl->assign( "domicilio", $cliente->getDireccion() );

            $xtpl->assign( "nacimiento", ArbolitoUIUtils::formatDateToView($cliente->getNacimiento()) );

            $xtpl->parse( "main.clientes.detalle" );


        }
        if ($clientes) {
            $xtpl->parse( "main.clientes" );
        }









	}







	public function getPDFRenderer(){

		$renderer = new DOMPDFRenderer();
		return $renderer;
	}
}
?>
