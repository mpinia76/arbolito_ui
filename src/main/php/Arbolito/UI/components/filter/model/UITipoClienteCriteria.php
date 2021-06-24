<?php
namespace Arbolito\UI\components\filter\model;


use Arbolito\UI\components\filter\model\UIArbolitoCriteria;

use Rasty\utils\RastyUtils;
use Arbolito\Core\criteria\TipoClienteCriteria;

/**
 * Representa un criterio de búsqueda
 * para tiposCliente.
 *
 * @author Marcos
 * @since 10/06/2021
 *
 */
class UITipoClienteCriteria extends UIArbolitoCriteria{


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
		return new TipoClienteCriteria();
	}

	public function buildCoreCriteria(){

		$criteria = parent::buildCoreCriteria();

		$criteria->setNombre( $this->getNombre() );


		return $criteria;
	}



}
