<?php

namespace Arbolito\UI\components\footer;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;


class FooterArbolito extends RastyComponent{


	public function __construct(){
	}

	public function getType(){

		return "FooterArbolito";

	}

	protected function parseXTemplate(XTemplate $xtpl){

        $xtpl->assign('year', date('Y'));

	}

}
?>
