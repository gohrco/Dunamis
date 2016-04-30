<?php


require 'bootstrap.php';

class DunamisTest extends PHPUnit_Framework_TestCase
{
	public $dunamis	=	null;
	
	public function setUp()
	{
		$this->dunamis	=	get_dunamis( 'dunamis' );
	}
	
	
	public function tearDown()
	{
		
	}
	
	
	public function testDunamisLoads()
	{
		$this->assertTrue( $this->dunamis !== null );
		$this->assertTrue( $this->dunamis !== false );
	}
	
	
	/**
	 * @depends testDunamisLoads
	 */
	public function testDunmodule()
	{
		$module	=	dunmodule( 'dunamis' );
		$this->assertTrue( is_object( $module ) );
	}
	
	
	/**
	 * @depends testDunamisLoads
	 */
	public function testDunloader()
	{
		$admin	=	dunloader( 'updates', 'dunamis' );
		$this->assertTrue( is_object( $admin ) );
	}
}