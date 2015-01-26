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
	

//Génère un tableau avec les mailinlists à afficher
function mailinglists_visibles(){
	include_spip('inc/config');
	$config_listes_checkbox=lire_config('reservations_mailsubscribers/listes_visibles');
	
	foreach(lire_config('mailsubscribers/lists',array()) AS $data){
		if(in_array($data['id_bak'],$config_listes_checkbox))
		$mailinglists_visibles[$data['id_bak']]=$data['titre'];
	}
	
	return $mailinglists_visibles;
}

function reservations_mailsubscribers_formulaire_charger($flux){
	// si creation d'un nouvel article lui attribuer la licence par defaut de la config
	if ($flux['args']['form'] == 'reservation') {
		include_spip('inc/config');
		$config=lire_config('reservations_mailsubscribers',array());
		$config_listes_visibles=isset($config['listes_visibles'])?$config['listes_visibles']:array();	
		$config_listes_caches=isset($config['listes_caches'])?$config['listes_caches']:array();	
		$lang=$GLOBALS['spip_lang'];
		
		$flux['data']['listes'] = "";	
		
		//Les liste visibles
		foreach(lire_config('mailsubscribers/lists',array()) AS $data){		
			if(
				(in_array($data['id_bak'],$config_listes_visibles)) AND
				($config[$data['id_bak'].'_lang']=='' OR $config[$data['id_bak'].'_lang']==$lang)){
				$flux['data']['mailinglists_visibles'][$data['id_bak']]=$data['titre'];
			}
			
		}
			

		//Les hidden listes
		
	
		$listes_caches=array();
		foreach($config_listes_caches AS $liste){
			
			if($config[$liste.'_lang']=='' OR $config[$liste.'_lang']==$lang){
				$listes_caches[]=$liste;
			}
			
		}
		$listes_caches=implode(',',$listes_caches);
		
		$flux['data']['listes_caches']=$listes_caches;
		
		$flux['data']['_hidden'] .= "<input type='hidden' name='listes_caches' value='$listes_caches' />";
				

	}
	return $flux;
} 
 
function reservations_mailsubscribers_formulaire_traiter($flux){
	// si creation d'un nouvel article lui attribuer la licence par defaut de la config
	if ($flux['args']['form'] == 'reservation') {
		$email=_request('email');
		
		$listes=_request('listes')?_request('listes'):array();
		
		
		if($listes_caches=_request('listes_caches')){
			$listes_caches=explode(',',$listes_caches);
			$listes=array_merge($listes,$listes_caches);
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

		$contexte=$flux['args']['contexte'];
		$champs = recuperer_fond('inclure/champs_listes',$contexte);
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
