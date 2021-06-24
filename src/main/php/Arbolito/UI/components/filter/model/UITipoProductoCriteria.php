<?php
namespace Arbolito\UI\components\filter\model;


use Arbolito\UI\components\filter\model\UIArbolitoCriteria;

use Rasty\utils\RastyUtils;
use Arbolito\Core\criteria\TipoProductoCriteria;

/**
 * Representa un criterio de búsqueda
 * para tiposProducto.
 *
 * @author Marcos
 * @since 05/03/2018
 *
 */
class UITipoProductoCriteria extends UIArbolitoCriteria{


	private $nombre;



	public function __construct(){

		parent::__construct();

	}

	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}


	protected function newCoreCriteria(){
		return new TipoProductoCriteria();
	}

	public function buildCoreCriteria(){

		$criteria = parent::buildCoreCriteria();

		$criteria->setNombre( $this->getNombre() );


		return $criteria;
	}



}
