<?php
namespace Arbolito\UI\components\filter\model;


use Arbolito\UI\components\filter\model\UIArbolitoCriteria;

use Rasty\utils\RastyUtils;
use Arbolito\Core\criteria\ClienteCriteria;

/**
 * Representa un criterio de búsqueda
 * para clientes.
 *
 * @author Marcos
 * @since 02/03/2018
 *
 */
class UIClienteCriteria extends UIArbolitoCriteria{


	private $nombre;
	private $documento;
	private $tieneCtaCte;

    private $tipoCliente;

    /**
     * @return mixed
     */
    public function getTipoCliente()
    {
        return $this->tipoCliente;
    }

    /**
     * @param mixed $tipoCliente
     */
    public function setTipoCliente($tipoCliente)
    {
        $this->tipoCliente = $tipoCliente;
    }

    private $nroSocio;

    /**
     * @return mixed
     */
    public function getNroSocio()
    {
        return $this->nroSocio;
    }

    /**
     * @param mixed $nroSocio
     */
    public function setNroSocio($nroSocio)
    {
        $this->nroSocio = $nroSocio;
    }

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


    private $nroSocioExacto;

    /**
     * @return mixed
     */
    public function getNroSocioExacto()
    {
        return $this->nroSocioExacto;
    }

    /**
     * @param mixed $nroSocioExacto
     */
    public function setNroSocioExacto($nroSocioExacto)
    {
        $this->nroSocioExacto = $nroSocioExacto;
    }


	protected function newCoreCriteria(){
		return new ClienteCriteria();
	}

	public function buildCoreCriteria(){

		$criteria = parent::buildCoreCriteria();

		$criteria->setNombre( $this->getNombre() );
		$criteria->setNroSocio( $this->getNroSocio() );
        $criteria->setNroSocioExacto( $this->getNroSocioExacto() );
        $criteria->setTipoCliente( $this->getTipoCliente() );
        $criteria->setDocumento( $this->getDocumento() );
		$criteria->setTieneCtaCte( $this->getTieneCtaCte() );

		return $criteria;
	}


	public function getDocumento()
	{
	    return $this->documento;
	}

	public function setDocumento($documento)
	{
	    $this->documento = $documento;
	}

	public function getTieneCtaCte()
	{
	    return $this->tieneCtaCte;
	}

	public function setTieneCtaCte($tieneCtaCte)
	{
	    $this->tieneCtaCte = $tieneCtaCte;
	}
}
