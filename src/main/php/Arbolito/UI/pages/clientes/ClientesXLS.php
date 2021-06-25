<?php
namespace Arbolito\UI\pages\clientes;

use Arbolito\UI\pages\ArbolitoPage;




use Arbolito\UI\utils\ArbolitoUIUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;
use Rasty\utils\LinkBuilder;



use Rasty\security\RastySecurityContext;

class ClientesXLS extends ArbolitoPage{



	public function __construct(){



	}

	public function getTitle(){
		return date('YmdHis').'_socios';
	}



	protected function parseXTemplate(XTemplate $xtpl){

		$title = $this->localize("admin_home.title");
		$subtitle = $this->localize("admin_home.subtitle");
		$xtpl->assign("app_title", $title );

	}




	public function getType(){

		return "ClientesXLS";

	}



}
?>
