<?php

/* Bootstrap! */
require dirname( dirname( __DIR__ ) ) . DIRECTORY_SEPARATOR . 'bootstrap.php';


/**
 * Test class for DunModule
 */
class DunModuleTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var DunModule
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        get_dunamis();
        $this->object	=	dunmodule( 'dunamis' );
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }
    
    
	/**
	 * @covers DunModule::__call
	 */
	public function testSetVariable()
	{
		$this->object->setTest( 'value' );
		$this->assertAttributeContains( 'value', '_test', $this->object );
		return $this->object;
	}
	
	
	/**
	 * @covers DunModule::__call
	 * @depends testSetVariable
	 */
	public function testHasVariable( $object )
	{
		$value = $object->hasTest();
		$this->assertTrue( $value );
		
		$this->assertFalse( $object->hasNothing() );
		return $object;
	}
	
	
	/**
	 * @covers DunModule::__call
	 * @depends testSetVariable
	 */
	public function testGetVariable( $object )
	{
		$value = $object->getTest();
		$this->assertTrue( $value == 'value' );
	}
}
?>
