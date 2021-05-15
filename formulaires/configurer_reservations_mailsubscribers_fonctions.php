<?php
/**
 * Utilisations de pipelines par Réservation 2 Mailsubscribers
 *
 * @plugin     Réservation 2 Mailsubscribers
 * @copyright  2014 - 2021
 * @author     Rainer
 * @licence    GNU/GPL
 * @package    SPIP\Reservations_mailsubscribers\Fonctions
 */

if (!defined('_ECRIRE_INC_VERSION')) return;



function traduire_tableau($l){
	$langues=array();
	foreach($l AS $lang){
		$langues[$lang]=traduire_nom_langue($lang);
	};

	return $langues;
}
