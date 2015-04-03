<?php
App::uses('Wallet', 'Model');

/**
 * Wallet Test Case
 *
 */
class WalletTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.wallet',
		'app.currency',
		'app.user',
		'app.default_wallet',
		'app.current_wallet',
		'app.category',
		'app.typename',
		'app.special',
		'app.transaction',
		'app.report'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Wallet = ClassRegistry::init('Wallet');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Wallet);

		parent::tearDown();
	}

}
