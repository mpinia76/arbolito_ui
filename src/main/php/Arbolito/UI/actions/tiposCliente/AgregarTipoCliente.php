<?php
namespace Arbolito\UI\actions\tiposCliente;


use Arbolito\UI\components\form\tipoCliente\TipoClienteForm;

use Arbolito\UI\service\UIServiceFactory;
use Arbolito\Core\model\TipoCliente;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se realiza el alta de una TipoCliente.
 *
 * @author Marcos
 * @since 10/06/2021
 */
class AgregarTipoCliente extends Action{


	public function execute(){

		$forward = new Forward();

		$page = PageFactory::build("TipoClienteAgregar");

		$tipoClienteForm = $page->getComponentById("tipoClienteForm");

		try {

			//creamos una nueva tipoCliente.
			$tipoCliente = new TipoCliente();

			//completados con los datos del formulario.
			$tipoClienteForm->fillEntity($tipoCliente);

			//agregamos el tipoCliente.
			UIServiceFactory::getUITipoClienteService()->add( $tipoCliente );

			$forward->setPageName( $tipoClienteForm->getBackToOnSuccess() );
			$forward->addParam( "tipoClienteOid", $tipoCliente->getOid() );

			$tipoClienteForm->cleanSavedProperties();


		} catch (RastyException $e) {

			$forward->setPageName( "TipoClienteAgregar" );
			$forward->addError( Locale::localize($e->getMessage())  );

			//guardamos lo ingresado en el form.
			$tipoClienteForm->save();
		}

		return $forward;

	}

}
?>
