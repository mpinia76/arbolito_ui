<?php
namespace Arbolito\UI\pages\clientes\agregar;

use Arbolito\UI\pages\ArbolitoPage;

use Arbolito\UI\service\UIServiceFactory;
use Rasty\utils\XTemplate;
use Arbolito\Core\model\Cliente;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class ClienteAgregar extends ArbolitoPage{

	/**
	 * cliente a agregar.
	 * @var Cliente
	 */
	private $cliente;


	public function __construct(){

		//inicializamos el cliente.
		$cliente = new Cliente();




        $ultimoSocio = UIServiceFactory::getUIClienteService()->getUltimo();


        $cliente->setNroSocio($ultimoSocio->getNroSocio()+1);

		//$cliente->setNombre("Bernardo");
		//$cliente->setEmail("ber@mail.com");
		$this->setCliente($cliente);


	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario
		//y utilizando permisos

		$menuGroup = new MenuGroup();

		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "form.volver") );
		$menuOption->setPageName("Clientes");
		$menuGroup->addMenuOption( $menuOption );


		return array($menuGroup);
	}

	public function getTitle(){
		return $this->localize( "cliente.agregar.title" );
	}

	public function getType(){

		return "ClienteAgregar";

	}

	protected function parseXTemplate(XTemplate $xtpl){
		$clienteForm = $this->getComponentById("clienteForm");
		$clienteForm->fillFromSaved( $this->getCliente() );

	}


	public function getCliente()
	{
	    return $this->cliente;
	}

	public function setCliente($cliente)
	{
	    $this->cliente = $cliente;
	}



	public function getMsgError(){
		return "";
	}
}
?>
