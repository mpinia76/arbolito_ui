<?php
namespace Arbolito\UI\pages\combos\agregar;

use Arbolito\Core\utils\ArbolitoUtils;
use Arbolito\UI\utils\ArbolitoUIUtils;

use Arbolito\UI\pages\ArbolitoPage;

use Rasty\utils\XTemplate;
use Arbolito\Core\model\Combo;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class ComboAgregar extends ArbolitoPage{

	/**
	 * combo a agregar.
	 * @var Combo
	 */
	private $combo;


	public function __construct(){

		//inicializamos el combo.
		$combo = new Combo();

		$combo->setFecha( new \Datetime() );

		//$combo->setCliente( ArbolitoUtils::getClienteDefault() );

		$this->setCombo($combo);


	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario
		//y utilizando permisos

		$menuGroup = new MenuGroup();

//		$menuOption = new MenuOption();
//		$menuOption->setLabel( $this->localize( "form.volver") );
//		$menuOption->setPageName("Combos");
//		$menuGroup->addMenuOption( $menuOption );
//

		return array($menuGroup);
	}

	public function getTitle(){
		return $this->localize( "combo.agregar.title" );
	}

	public function getType(){

		return "ComboAgregar";

	}

	protected function parseXTemplate(XTemplate $xtpl){

		ArbolitoUIUtils::setProductosComboSession( array() );
		$comboForm = $this->getComponentById("comboForm");
		$comboForm->fillFromSaved( $this->getCombo() );
	}


	public function getCombo()
	{
	    return $this->combo;
	}

	public function setCombo($combo)
	{
	    $this->combo = $combo;
	}



	public function getMsgError(){
		return "";
	}
}
?>
