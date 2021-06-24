<?php
namespace Arbolito\UI\components\filter\model;


use Arbolito\UI\components\filter\model\UIArbolitoCriteria;

use Rasty\utils\RastyUtils;
use Arbolito\Core\criteria\TarjetaCriteria;

/**
 * Representa un criterio de búsqueda
 * para tiposProducto.
 *
 * @author Marcos
 * @since 28/03/2018
 *
 */
class UITarjetaCriteria extends UIArbolitoCriteria{


	private $cliente;

	private $marca;

	private $nro;

	public function __construct(){

		parent::__construct();

	}




	protected function newCoreCriteria(){
		return new TarjetaCriteria();
	}

	public function buildCoreCriteria(){

		$criteria = parent::buildCoreCriteria();

		$criteria->setCliente( $this->getCliente() );
		$criteria->setMarca( $this->getMarca() );
		$criteria->setNro( $this->getNro() );
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

	public function getMarca()
	{
	    return $this->marca;
	}

	public function setMarca($marca)
	{
	    $this->marca = $marca;
	}

	public function getNro()
	{
	    return $this->nro;
	}

	public function setNro($nro)
	{
	    $this->nro = $nro;
	}
}
