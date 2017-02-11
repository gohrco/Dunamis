<?php



class test extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		require_once dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'dunamis.php';
	}
	
	
	public function testGet_dunamis_function_exists()
	{
		$this->assertTrue( function_exists( 'get_dunamis' ) );
	}
	
	
	public function testGet_dunamis_is_object()
	{
		$dunamis	=	get_dunamis();
		$this->assertTrue( is_object( $dunamis ) );
		return $dunamis;
	}
	
	
	public function testDunimport_loads_core_environment()
	{
		$result	=	dunimport( 'core.environment' );
		$this->assertTrue( $result == 'core' );
	}
	
	
	public function testDunimport_loads_uri_without_environement()
	{
		$result	=	dunimport( 'uri' );
		$this->assertTrue( $result == 'core' );
	}
	
	
	public function testDunimport_loads_uri_with_environement()
	{
		$result	=	dunimport( 'uri', true );
		$this->assertTrue( $result == 'core' );
	}
	
	
	public function testDunimport_loads_error_without_environement()
	{
		$result	=	dunimport( 'error' );
		$this->assertTrue( $result == 'core' );
	}
	
	
	public function testDunimport_loads_error_with_environment()
	{
		$result	=	dunimport( 'error', true );
		$this->assertTrue( $result == 'core' );
	}
	
	
	public function testDunimport_loads_debug_without_environement()
	{
		$result	=	dunimport( 'debug' );
		$this->assertTrue( $result == 'core' );
	}
	
	
	public function testDunimport_loads_debug_with_environment()
	{
		$result	=	dunimport( 'debug', true );
		$this->assertTrue( $result == 'core' );
	}
	
	
	public function testDunloader_loads_language_object()
	{
		$lang	=	dunloader( 'language' );
		$this->assertTrue( is_a( $lang, 'DunLanguage' ) );
	}
	
}


class testDunamis extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		require_once dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'dunamis.php';
	}
	
	
	public function testFindEnvironment_is_not_false()
	{
		$dunamis	=	new Dunamis();
		$this->assertTrue( $dunamis->findEnvironment() );
		return $dunamis;
	}
	
	
	public function testInitialise_is_not_false()
	{
		$dunamis	=	new Dunamis();
		$this->assertTrue( $dunamis->initialise() );
		return $dunamis;
	}
	
	
	/**
	 * @depends testFindEnvironment_is_not_false
	 */
	public function testLoadEnvironment_is_not_false( $dunamis )
	{
		$this->assertTrue( $dunamis->loadEnvironment() );
	}
	
	

	/**
	 * @depends testFindEnvironment_is_not_false
	 */
	public function testLoadModule_finds_core_dunamis_module( $dunamis )
	{
		$this->assertTrue( is_a( $dunamis->loadModule( 'dunamis' ), 'DunamisDefaultDunModule' ) );
	}
}
