<?php


require 'bootstrap.php';

class DunamisTest extends PHPUnit_Framework_TestCase
{
	public $dunamis	=	null;
	
	public function setUp()
	{
		$this->dunamis	=	get_dunamis();
	}
	
	
	public function tearDown()
	{
		
	}
	
	
	public function testDunamisLoads()
	{
		$this->assertTrue($this->dunamis !== null );
	}
	
	
	public function testDunmodule()
	{
		$module	=	dunmodule( 'dunamis' );
		$this->assertTrue( is_object( $module ) );
	}
	
	
	public function testDunloader()
	{
		$admin	=	dunloader( 'updates', 'dunamis' );
		$this->assertTrue( is_object( $admin ) );
	}
}