<?php
/*
Plugin Name: Contact Form 7 Mail Conditions
Plugin URI: http://www.triggerco.de
Description: Helps to create conditions in Mails.
Author: Tobias Braner
Version: 0.0.1
Author URI: http://www.tobiasbraner.de
*/

define('WPCF7MC_EXPRESSION', 0);
define('WPCF7MC_VARIABLE', 1);
define('WPCF7MC_VALUE', 2);

/**
 * Before the WP Contact Form 7 Plugin sents a mail this plugin becomes active.
 * It looks for if-conditions written in shortcode-style and evaluates if the
 * condition variable is empty or not. Depending on that the block between
 * [if] and [/if] is inserted into the mail or not.
 *
 * @example
 * [if phone]Phone number: [phone][/if]
 *
 * @package default
 * @author Tobias Braner
 **/
class Contact_Form_7_Mail_Conditions {

	/**
	 * Creates a new instance of the Mail Conditionals plugin.
	 *
	 * @return Contact_Form_7_Mail_Conditions
	 * @author Tobias Braner
	 **/
	public function __construct($regexp = '/\[if\s+(\S+?)\](.*?)\[\/if\]/') {
		$this->init_action();
		$this->regexp = $regexp;
	}

	/**
	 * Modifies the emails by replacing the conditionals [if field_name][/if]
	 *
	 * @param [Object] $cf7 the contanct form 7 object
	 * @return void
	 * @author Tobias Braner
	 **/
	public function before_send_mail(&$cf7) {
		$mail_body = $cf7->mail['body'];
		$cf7->mail['body'] = $this->process_conditions($cf7, $cf7->mail['body']);
		$cf7->mail_2['body'] = $this->process_conditions($cf7, $cf7->mail_2['body']);
	}

	/**
	 * Takes the wpcf7 object and replaces all conditions.
	 *
	 * @return void
	 * @author Tobias Braner
	 **/
	private function process_conditions(&$cf7, $mail_body) {
		$updated_email_body = $mail_body;
		$matches = array();
		$num_matches = preg_match_all($this->regexp, $mail_body, $matches);
		for ($i=0; $i < $num_matches; $i++) { 
			$expression = $matches[WPCF7MC_EXPRESSION][$i];
			$variable = $matches[WPCF7MC_VARIABLE][$i];
			$value = $matches[WPCF7MC_VALUE][$i];
			if (empty($cf7->posted_data[$variable]) and array_key_exists($variable, $cf7->posted_data)) {
				$updated_email_body = str_replace($expression, '', $updated_email_body);
			} else {
				$updated_email_body = str_replace($expression, $value, $updated_email_body);
			}
		}
		return $updated_email_body;
	}

	/**
	 * Initializes the action wpcf7_before_send_mail of the WPCF7 Plugin.
	 *
	 * @return void
	 * @author Tobias Braner
	 **/
	private function init_action() {
		if (function_exists('add_action'))
			add_action("wpcf7_before_send_mail", array($this, 'before_send_mail'));
	}

} // END class 

new Contact_Form_7_Mail_Conditions;