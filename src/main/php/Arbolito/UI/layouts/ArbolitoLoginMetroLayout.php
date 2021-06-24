<?php

namespace Arbolito\UI\layouts;

use Rasty\Layout\layout\Rasty\Layout;

use Rasty\utils\XTemplate;


class ArbolitoLoginMetroLayout extends ArbolitoMetroLayout{

	public function getXTemplate($file_template=null){
		return parent::getXTemplate( dirname(__DIR__) . "/layouts/ArbolitoLoginMetroLayout.htm" );
	}

	public function getType(){

		return "ArbolitoLoginMetroLayout";

	}

}
?>
