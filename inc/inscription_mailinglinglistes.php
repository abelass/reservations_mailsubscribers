<?php


if (!defined('_ECRIRE_INC_VERSION')) return;

function inc_inscription_mailinglinglistes_dist($email){
	$listes=_request('listes')?_request('listes'):array();
	
	//Les liste cachés ne sontpas pris en compte si l'abonné est désinscrit ou à la poubelle
	if(!$id_mailsubscriber=sql_getfetsel('id_mailsubscriber','spip_mailsubscribers','email='.sql_quote($email).' AND statut IN ("refuse","poubelle")') OR count($listes)>0){
		if($listes_caches=_request('listes_caches')){
		$listes_caches=explode(',',$listes_caches);
		$listes=array_merge($listes,$listes_caches);
		}
	}
	
	//On inscrit si il y a des listes à inscrire		
	if(count($listes)>0){		
		$options = array(
			'lang'=>$GLOBALS['spip_lang'],
			'nom'=>_request('nom'),
			'listes'=>$listes);	
		$newsletter_subscribe = charger_fonction("subscribe","newsletter");
		$newsletter_subscribe($email,$options);	
	}
	return;
}
