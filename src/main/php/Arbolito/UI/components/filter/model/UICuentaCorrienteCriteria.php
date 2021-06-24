<?php
namespace Arbolito\UI\components\filter\model;


use Arbolito\UI\components\filter\model\UIArbolitoCriteria;

use Rasty\utils\RastyUtils;
use Arbolito\Core\criteria\CuentaCorrienteCriteria;

/**
 * Representa un criterio de búsqueda
 * para tiposProducto.
 *
 * @author Marcos
 * @since 07/04/2018
 *
 */
class UICuentaCorrienteCriteria extends UIArbolitoCriteria{


	private $cliente;



	public function __construct(){

		parent::__construct();

	}




	protected function newCoreCriteria(){
		return new CuentaCorrienteCriteria();
	}

	public function buildCoreCriteria(){

		$criteria = parent::buildCoreCriteria();

		$criteria->setCliente( $this->getCliente() );

		return $criteria;
	}


	public function getCliente()
	{
	    return $this->cliente;
	}

	public function setCliente($cliente)
	{
	    $this->cliente = $cliente;
	}


}
