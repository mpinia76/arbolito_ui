<?php
namespace Arbolito\UI\components\filter\model;


use Arbolito\UI\components\filter\model\UIArbolitoCriteria;

use Rasty\utils\RastyUtils;
use Arbolito\Core\criteria\ComboCriteria;

/**
 * Representa un criterio de búsqueda
 * para combos.
 *
 * @author Marcos
 * @since 28/08/2019
 *
 */
class UIComboCriteria extends UIArbolitoCriteria{



	private $nombre;



	public function __construct(){

		parent::__construct();

	}



	protected function newCoreCriteria(){
		return new ComboCriteria();
	}

	public function buildCoreCriteria(){

		$criteria = parent::buildCoreCriteria();

		$criteria->setNombre( $this->getNombre() );


		return $criteria;
	}








	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}
}
