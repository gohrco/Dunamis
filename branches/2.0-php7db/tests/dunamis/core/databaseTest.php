<?php


class DunDatabaseTest extends PHPUnit_Framework_TestCase
{
	
	
	protected function setUp()
	{
		require_once dirname( dirname( dirname( __DIR__ ) ) ) . DIRECTORY_SEPARATOR . 'dunamis.php';
		$dunamis	=	get_dunamis();
		dunimport( 'database', true );
	}
	
	
	/**
	 * @dataProvider PdoProvider
	 */
	public function testInit_new_database( $user, $pass, $host, $name, $expects )
	{
		$values	=	array( 'hostname' => $host, 'username' => $user, 'password' => $pass, 'database' => $name );
		$check	=	new DunDatabase( $values );
		
		if ( $expects ) {
			$this->assertTrue( $check->isConnected() );
		}
		else {
			$this->assertFalse( $check->isConnected() );
		}
	}
	
	
	public function testnew_connection()
	{
		$values	=	array( 'hostname' => 'localhost', 'username' => 'root', 'password' => 'cruiser', 'database' => 'joomla', true );
		$db		=	DunDatabase :: getInstance( $values );
		$this->assertTrue( $db->isConnected() );
		return $db;
	}
	
	
	/**
	 * @depends testnew_connection
	 */
	public function testGetNumRows( $db )
	{
		$db->setQuery( "SELECT * FROM jos_modules" );
		$result	=	$db->getNumRows();
		$this->assertTrue( $result == 0 );
		
		$db->loadObjectList();
		$result	=	$db->getNumRows();
		$this->assertTrue( $result == 15 );
	}
	
	
	/**
	 * @depends testnew_connection
	 */
	public function testGetInsertId( $db )
	{
		$db->setQuery( "INSERT INTO testtable ( `name` ) VALUES ( :name )", array( ':name' => 'This is a test' ) );
		$db->query();
		$result	=	$db->getInsertId();
		
		$this->assertTrue( $result > 0 );
	}
	
	
	/**
	 * @depends testnew_connection
	 */
	public function testQuery( $db )
	{
		$db->setQuery( "SELECT * FROM jos_users" );
		$this->assertTrue( $db->query() );
	}
	
	
	/**
	 * @depends testnew_connection
	 */
	public function testLoadObject( $db )
	{
		$db->setQuery( "SELECT * FROM jos_users" );
		$result	=	$db->loadObject();
		$this->assertObjectHasAttribute( 'id', $result );
	}
	
	
	/**
	 * @depends testnew_connection
	 */
	public function testLoadObjectList( $db )
	{
		$db->setQuery( "SELECT * FROM jos_modules" );
		$result	=	$db->loadObjectList();
		$this->assertTrue( is_array( $result ) );
		$this->assertTrue( count( $result ) == 15 );
	}
	
	
	/**
	 * @depends testnew_connection
	 */
	public function testLoadAssoc( $db )
	{
		$db->setQuery( "SELECT * FROM jos_users" );
		$result	=	$db->loadRow();
		$this->assertArrayHasKey( 'id', $result );
	}
	
	
	/**
	 * @depends testnew_connection
	 */
	public function testLoadAssocWithPrepareExecute( $db )
	{
		$db->setQuery( "SELECT * FROM jos_extensions WHERE `name` = :name", array( ':name' => 'com_banners' ) );
		$result = $db->loadRow();
		$this->assertArrayHasKey( 'element', $result );
	}
	
	
	/**
	 * @depends testnew_connection
	 */
	public function testLoadAssocList( $db )
	{
		$db->setQuery( "SELECT * FROM jos_users" );
		$result	=	$db->loadRowList();
		$this->assertTrue( count( $result ) > 0 );
	}
	
	
	/**
	 * @depends testnew_connection
	 */
	public function testLoadAssocListWithPrepareExecute( $db )
	{
		$db->setQuery( "SELECT * FROM jos_extensions WHERE `name` = :name", array( ':name' => 'com_banners' ) );
		$result = $db->loadRowList();
		$this->assertTrue( count( $result ) == 1 );
	}
	
	
	/**
	 * @depends testnew_connection
	 */
	public function testLoadRow( $db )
	{
		$db->setQuery( "SELECT * FROM jos_users" );
		$result	=	$db->loadRow();
		$this->assertArrayHasKey( 'id', $result );
	}
	
	
	/**
	 * @depends testnew_connection
	 */
	public function testLoadRowWithPrepareExecute( $db )
	{
		$db->setQuery( "SELECT * FROM jos_extensions WHERE `name` = :name", array( ':name' => 'com_banners' ) );
		$result = $db->loadRow();
		$this->assertArrayHasKey( 'element', $result );
	}
	
	
	/**
	 * @depends testnew_connection
	 */
	public function testLoadRowList( $db )
	{
		$db->setQuery( "SELECT * FROM jos_users" );
		$result	=	$db->loadRowList();
		$this->assertTrue( count( $result ) > 0 );
	}
	
	
	/**
	 * @depends testnew_connection
	 */
	public function testLoadRowListWithPrepareExecute( $db )
	{
		$db->setQuery( "SELECT * FROM jos_extensions WHERE `name` = :name", array( ':name' => 'com_banners' ) );
		$result = $db->loadRowList();
		$this->assertTrue( count( $result ) == 1 );
	}
	
	
	/**
	 * @depends testnew_connection
	 */
	public function testLoadResultWithPrepare( $db )
	{
		$db->setQuery( "SELECT `title` FROM `jos_modules` WHERE `id` = :id", array( ':id' => 9 ) );
		$result	=	$db->loadResult();
		$this->assertTrue( $result == 'Quick Icons' );
	}
	
	
	/**
	 * @depends testnew_connection
	 */
	public function testLoadResultArrayWithPrepare( $db )
	{
		$db->setQuery( "SELECT * FROM `jos_modules`" );
		$result	=	$db->loadResultArray( 2 );
		$this->assertTrue( count( $result ) == 15 );
	}
	
	
	/**
	 * @depends testnew_connection
	 */
	public function testSetQueryFalseOnEmpty( $db )
	{
		$this->assertFalse( $db->setQuery( null ) );
	}
	
	
	/**
	 * @depends testnew_connection
	 */
	public function testSetQueryWithQueryIsTrue( $db )
	{
		$this->assertTrue( $db->setQuery( "SELECT * FROM jos_users" ) );
	}
	
	
	/**
	 * @depends testnew_connection
	 */
	public function testParseFile( $db )
	{
		$path	=	DUN_ENV_PATH . 'core' . DIRECTORY_SEPARATOR . 'dunamis' . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'parsefile.sql';
		$this->assertTrue( is_array( $db->parseFile( $path ) ) );
	}
	
	
	/**
	 * @depends testnew_connection
	 */
	public function testsetError( $db )
	{
		$this->assertTrue( $db->setError( 'Test Error Message' ) );
	}
	
	
	public function PdoProvider()
	{
		return	array(
				array( 'root', 'cruiser', 'localhost', 'joomla', true ),
				array( 'imnot', 'auser', 'localhost', 'whmcs', false )
				);
	}
}
