<?php
/*
 * Plugin Name: Houdini
 * Description: Fait disparaitre the_content pour les utilisateurs non connectés
 * Version: 6.6.6
 * License: GPL2
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
class Houdini {
	public function __construct(){
		//Ajout du filtre impactant the_content
		add_filter('the_content', array($this, 'make_it_disappear'), 10);
		add_action('init', array($this, 'ilovecookies'), 10);
		add_filter('get_the_excerpt', array($this, 'excerpt_extended'));

	}
	public function make_it_disappear($content){
		if ($_COOKIE["houdini"] == 'activated') {
			return $content;
		}
		else {
			return '';
		}
	}
	public function ilovecookies () {
		if (is_user_logged_in()) {
			setcookie('houdini', 'activated', time()+3600);
		}
		else {
			setcookie('houdini', 'disappeared', time()+3600);
		}
	}

	public function excerpt_extended($excerpt_old) {
		$excerpt = $excerpt_old . ' <br/><a href="' . get_permalink() . '">Voir plus</a>';
		return $excerpt;
	}


}

new Houdini();