<?php
/**
 * Utilisations de pipelines par Réservation 2 Mailsubscribers
 *
 * @plugin     Réservation 2 Mailsubscribers
 * @copyright  2014
 * @author     Rainer
 * @licence    GNU/GPL
 * @package    SPIP\Reservations_mailsubscribers\Pipelines
 */

if (!defined('_ECRIRE_INC_VERSION')) return;
	

/*
 * Un fichier de pipelines permet de regrouper
 * les fonctions de branchement de votre plugin
 * sur des pipelines existants.
 */


function reservations_mailsubscribers_formulaire_traiter($flux){
	// si creation d'un nouvel article lui attribuer la licence par defaut de la config
	if ($flux['args']['form'] == 'reservation') {
		include_spip('inc/config');
		$email=_request('email');
		$config=lire_config('reservations_mailsubscribers',array());
		$listes=isset($config['listes'])?$config['listes']:array();
		$options = array('lang'=>$GLOBALS['spip_lang'],'nom'=>_request('nom'));
		
		$options['listes'] = $listes;
				

		$newsletter_subscribe = charger_fonction("subscribe","newsletter");
		$newsletter_subscribe($email,$options);		
		spip_log($newsletter_subscribe,'teste');
	}
	return $flux;
}
function reservations_mailsubscribers_header_prive($flux){
	$flux .= '<link rel="stylesheet" href="' . _DIR_PLUGIN_RESERVATIONS_MAILSUBSCRIBERS  .'css/styles_admin.css" type="text/css" media="all" />';
	return $flux;
}
?>