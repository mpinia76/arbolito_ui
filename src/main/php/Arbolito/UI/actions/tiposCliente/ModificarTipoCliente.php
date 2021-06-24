<?php
namespace Arbolito\UI\actions\tiposCliente;

use Arbolito\UI\components\form\tipoCliente\TipoClienteForm;

use Arbolito\UI\service\UIServiceFactory;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\factory\ComponentConfig;
use Rasty\factory\ComponentFactory;

use Rasty\i18n\Locale;

use Rasty\factory\PageFactory;

/**
 * se realiza la actualización de una tipoCliente.
 *
 * @author Marcos
 * @since 05/03/2018
 */
class ModificarTipoCliente extends Action{


	public function execute(){

		$forward = new Forward();

		$page = PageFactory::build("TipoClienteModificar");

		$tipoClienteForm = $page->getComponentById("tipoClienteForm");

		$oid = $tipoClienteForm->getOid();

		try {

			//obtenemos la tipoCliente.
			$tipoCliente = UIServiceFactory::getUITipoClienteService()->get($oid );

			//lo editamos con los datos del formulario.
			$tipoClienteForm->fillEntity($tipoCliente);

			//guardamos los cambios.
			UIServiceFactory::getUITipoClienteService()->update( $tipoCliente );

			$forward->setPageName( $tipoClienteForm->getBackToOnSuccess() );
			$forward->addParam( "tipoClienteOid", $tipoCliente->getOid() );

			$tipoClienteForm->cleanSavedProperties();

		} catch (RastyException $e) {

			$forward->setPageName( "TipoClienteModificar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			$forward->addParam("oid", $oid );

			//guardamos lo ingresado en el form.
			$tipoClienteForm->save();

		}
		return $forward;

	}

}
?>
