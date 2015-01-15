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

function reservations_mailsubscribers_formulaire_charger($flux){
	// si creation d'un nouvel article lui attribuer la licence par defaut de la config
	if ($flux['args']['form'] == 'reservation') {
		include_spip('inc/config');
		$config=lire_config('reservations_mailsubscribers',array());
		
		//Les valeurs des listes visibles
		if(isset($config['listes_checkbox'])){
			foreach($config['listes_checkbox'] AS $liste){
				$flux['data'][$liste] = '';
			}
		}
		
		//Les hidden listes
		if(isset($config['listes_hidden'])){
			$listes_hidden=array();
			foreach($config['listes_hidden'] AS $liste){
				$listes_hidden[]=$liste;
			}
			$listes_hidden=implode(',',$listes_hidden);
			$flux['data']['_hidden'] .= "<input type='hidden' name='listes_hidden' value='$listes_hidden' />";
		}		

	}
	return $flux;
} 
 
function reservations_mailsubscribers_formulaire_traiter($flux){
	// si creation d'un nouvel article lui attribuer la licence par defaut de la config
	if ($flux['args']['form'] == 'reservation') {
		$email=_request('email');
		
		$listes=_request('listes')?_request('listes'):array();
		
		if($liste_hidden=_request('listes_hidden')){
			$liste_hidden=explode(',',$liste_hidden);
			$listes=array_merge($listes,$liste_hidden);
			}
		$options = array('lang'=>$GLOBALS['spip_lang'],'nom'=>_request('nom'));
		
		$options['listes'] = $listes;
				

		$newsletter_subscribe = charger_fonction("subscribe","newsletter");
		$newsletter_subscribe($email,$options);		
	}
	return $flux;
}

function reservations_mailsubscribers_recuperer_fond($flux){
	if ($flux['args']['fond'] == 'formulaires/reservation'){
		$champs = recuperer_fond('inclure/champs_listes',array('listes'=>_request(listes)));
		$flux['data']['texte'] = str_replace('<!--extra-->', '<!--extra-->' .$champs, $flux['data']['texte']);
	}
	return $flux;
}

// Insertion dans head de l'espace privé
function reservations_mailsubscribers_header_prive($flux){
	$flux .= '<link rel="stylesheet" href="' . _DIR_PLUGIN_RESERVATIONS_MAILSUBSCRIBERS  .'css/styles_admin.css" type="text/css" media="all" />';
	return $flux;
}
?>