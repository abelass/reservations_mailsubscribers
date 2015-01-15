<?php
/**
 * Utilisations de pipelines par Réservation 2 Mailsubscribers
 *
 * @plugin     Réservation 2 Mailsubscribers
 * @copyright  2014
 * @author     Rainer
 * @licence    GNU/GPL
 * @package    SPIP\Reservations_mailsubscribers\Fpnctions
 */

if (!defined('_ECRIRE_INC_VERSION')) return;
	
//Génère un tableau avec les mailinlists à afficher
function mailinglists_visibles(){
	include_spip('inc/config');
	$config_listes_checkbox=lire_config('reservations_mailsubscribers/listes_visibles');
	$mailinglists_visibles=array();
	foreach(lire_config('mailsubscribers/lists',array()) AS $data){
		if(in_array($data['id_bak'],$config_listes_checkbox))
		$mailinglists_visibles[$data['id_bak']]=$data['titre'];
	}
	
	return $mailinglists_visibles;
}

function traduire_tableau($l){
	$langues=array();
	foreach($l AS $lang){
		$langues[$lang]=traduire_nom_langue($lang);
	};
	
	return $langues;
}
