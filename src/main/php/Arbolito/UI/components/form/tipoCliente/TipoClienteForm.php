<?php

namespace Arbolito\UI\components\form\tipoCliente;

use Arbolito\UI\components\filter\model\UITipoClienteCriteria;

use Arbolito\UI\service\finder\TipoClienteFinder;



use Arbolito\UI\utils\ArbolitoUIUtils;

use Arbolito\UI\service\UIServiceFactory;


use Rasty\Forms\form\Form;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;



use Rasty\utils\LinkBuilder;

/**
 * Formulario para tipoCliente

 * @author Marcos
 * @since 10/06/2021
 */
class TipoClienteForm extends Form{



	/**
	 * label para el cancel
	 * @var string
	 */
	private $labelCancel;


	/**
	 *
	 * @var TipoCliente
	 */
	private $tipoCliente;


	public function __construct(){

		parent::__construct();
		$this->setLabelCancel("form.cancelar");

		$this->addProperty("nombre");
        $this->addProperty("pagaCuota");

		$this->setBackToOnSuccess("TiposCliente");
		$this->setBackToOnCancel("TiposCliente");


	}

	public function getOid(){

		return $this->getComponentById("oid")->getPopulatedValue( $this->getMethod() );
	}


	public function getType(){

		return "TipoClienteForm";

	}

	public function fillEntity($entity){

		parent::fillEntity($entity);




	}

	protected function parseXTemplate(XTemplate $xtpl){

		parent::parseXTemplate($xtpl);


		$xtpl->assign("cancel", $this->getLinkCancel() );
		$xtpl->assign("lbl_cancel", $this->localize( $this->getLabelCancel() ) );

		$xtpl->assign("lbl_nombre", $this->localize("tipoCliente.nombre") );
        $xtpl->assign("lbl_pagaCuota", $this->localize("tipoCliente.pagaCuota") );


	}


	public function getLabelCancel()
	{
	    return $this->labelCancel;
	}

	public function setLabelCancel($labelCancel)
	{
	    $this->labelCancel = $labelCancel;
	}



	public function getTipoCliente()
	{
	    return $this->tipoCliente;
	}

	public function setTipoCliente($tipoCliente)
	{
	    $this->tipoCliente = $tipoCliente;

	}

	public function getLinkCancel(){
		$params = array();

		return LinkBuilder::getPageUrl( $this->getBackToOnCancel() , $params) ;
	}




}
?>
