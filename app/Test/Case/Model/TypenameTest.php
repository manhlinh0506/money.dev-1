<?php
App::uses('Typename', 'Model');

/**
 * Typename Test Case
 *
 */
class TypenameTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.typename',
		'app.category',
		'app.wallet',
		'app.special',
		'app.transaction'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Typename = ClassRegistry::init('Typename');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Typename);

		parent::tearDown();
	}

}
