<?php

require_once(dirname(__file__) . '/../contact_form_7_mail_conditions.php');

class PluginTest extends PHPUnit_Framework_TestCase {

	public function testPlugin () {
		
		$cf7mc = new Contact_Form_7_Mail_Conditions;

		$cf7_test_object = new stdClass;

		$cf7_test_object->posted_data = array(
			'not-set-or-empty' => '',
			'set' => 'set',
			'age' => 19
		);

		$cf7_test_object->mail = array(
			'body' => '[if not-set-or-empty]Foo[/if][if set]Bar[/if]'
		);

		$cf7_test_object->mail_2 = array(
			'body' => '[if not-set-or-empty]Foo[/if][if set]Bar[/if]'
		);

		$cf7mc->before_send_mail($cf7_test_object);

		$this->assertEquals($cf7_test_object->mail['body'], 'Bar');
		$this->assertEquals($cf7_test_object->mail_2['body'], 'Bar');

	}
}