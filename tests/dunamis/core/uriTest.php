<?php



/**
 * Test class for DunUri.
 * Generated by PHPUnit on 2013-10-16 at 14:46:48.
 */
class DunUriTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var DunUri
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
    	// We need to set test variables for CLI usage
    	$_SERVER['HTTP_HOST']	=	'jwhmcs.com';
    	$_SERVER['SCRIPT_NAME']	=	'/hosting/index.php';
    	
        dunloader( 'uri', true );
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    	
    }

	/**
     * @covers DunUri::getInstance
     */
    public function testGetInstanceServer()
    {
    	// We are setting the _SERVER variables in bootstrap file
    	$uri	=	DunUri :: getInstance();
    	
    	$this->assertInstanceOf( 'DunUri', $uri );
    	
    	$this->assertContains( 'hosting', $uri->getPath() );
    	$this->assertContains( 'jwhmcs.com', $uri->getHost() );
    	
    	$this->assertFalse( $uri->getScheme() == 'https' );
    	
    }
	
    /**
     * @covers DunUri::getInstance
     */
    public function testGetInstanceFullURL()
    {
    	$uri	=	DunUri :: getInstance( 'https://www.gohigheris.com' );
    	 
    	$this->assertInstanceOf( 'DunUri', $uri );
    	$this->assertEmpty( $uri->getPath() );
    	$this->assertContains( 'gohigheris', $uri->getHost() );
    	$this->assertTrue( $uri->getScheme() == 'https' );
    }
    
    /**
     * @covers DunUri::getInstance
     */
    public function testGetInstanceServerPathOnly()
    {
    	$uri	=	DunUri :: getInstance( 'support/tickets/index.php' );
    	
    	$this->assertInstanceOf( 'DunUri', $uri );
    	$this->assertContains( 'tickets', $uri->getPath() );
    	$this->assertEmpty( $uri->getHost() );
    	$this->assertFalse( $uri->getScheme() == 'https' );
    }
    
    /**
     * @covers DunUri::getInstance
     */
    public function testGetInstance()
    {
    	$uri	=	DunUri :: getInstance( 'https://www.gohigheris.com/documentation/index.php?variable=a&item=b' );
    	 
    	$this->assertInstanceOf( 'DunUri', $uri );
    	$this->assertContains( 'documentation', $uri->getPath() );
    	$this->assertContains( 'gohigheris.com', $uri->getHost() );
    	$this->assertTrue( $uri->getScheme() == 'https' );
    	$this->assertTrue( $uri->getVar( 'variable' ) == 'a' );
    	$this->assertTrue( $uri->getVar( 'item' ) == 'b' );
    	
    	return $uri;
    }
    
    /**
     * @covers DunUri::base
     * @depends testGetInstance
     */
    public function testBase( $uri )
    {
    	if ( BAMBOO ) {
    		$this->assertTrue( DunUri :: base() == 'http://jwhmcs.com/hosting', DunUri :: base() );
    	}
    	else {
	    	$this->assertTrue( DunUri :: base() == 'http://localhost.com/mods/whmcs' );
    	}
    }
    
    /**
     * @covers DunUri::base
     * @depends testGetInstance
     */
    public function testBasePathOnly( $uri )
    {
    	$this->assertTrue( DunUri :: base( true ) == '/hosting' );
    }

    /**
     * @covers DunUri::cleanForInstaller
     */
    public function testCleanForInstaller()
    {
    	$uri	=	DunUri :: getInstance( 'https://www.gohigheris.com/subfolder/install/documentation/index.php?variable=a&item=b' );
    	$uri->cleanForInstaller();
    	
    	$this->assertTrue( $uri->toString() == 'https://www.gohigheris.com/subfolder/?variable=a&item=b' );
    }

    /**
     * @covers DunUri::root
     */
    public function testRootNoPath()
    {
    	$this->assertTrue( DunUri :: root( false, false ) == 'http://jwhmcs.com/', DunUri :: root( false, false ) );
    }
    
    /**
     * @covers DunUri::root
     */
    public function testRootWithPath()
    {
    	$this->assertTrue( DunUri :: root( false, '/mycustompath/test' ) == 'http://jwhmcs.com/mycustompath/test', DunUri :: root( false, '/mycustompath/test' ) );
    }
    
    /**
     * @covers DunUri::root
     */
    public function testRootPathOnly()
    {
    	$this->assertTrue( DunUri :: root( true ) == '/mycustompath/test', DunUri :: root( true ) );
    }
    
    /**
     * @covers DunUri::current
     */
    public function testCurrent()
    {
    	$this->assertTrue( DunUri :: current() == 'http://jwhmcs.com/hosting/index.php', sprintf( 'Test returned %s', DunUri :: current() ) );
    }

    /**
     * @covers DunUri::toString
     * @depends testGetInstance
     */
    public function testToString( $uri )
    {
    	$this->assertTrue( $uri->toString() == 'https://www.gohigheris.com/documentation/index.php?variable=a&item=b' );
    }

    /**
     * @covers DunUri::setVar
     * @depends testGetInstance
     */
    public function testSetVar( $uri )
    {
    	$original = $uri->setVar( 'variable', 'b' );
    	$this->assertTrue( $original == 'a' );
    	return $uri;
    }

    /**
     * @covers DunUri::getVar
     * @depends testSetVar
     */
    public function testGetVar( $uri )
    {
    	$value = $uri->getVar( 'variable' );
    	$this->assertTrue( $value == 'b' );
    	return $uri;
    }
    
    
    /**
     * @covers DunUri::getVar
     * @depends testSetVar
     */
    public function testGetVarNotSet( $uri )
    {
    	$value = $uri->getVar( 'another', 'c' );
    	$this->assertTrue( $value == 'c' );
    	return $uri;
    }

    /**
     * @covers DunUri::delVar
     * @depends testGetInstance
     */
    public function testDelVar( $uri )
    {
    	$uri->delVar( 'variable' );
    	$value	=	$uri->getVar( 'variable' );
    	$this->assertTrue( $value == null );
    }

    /**
     * @covers DunUri::delVars
     * @depends testGetInstance
     */
    public function testDelVars( $uri )
    {
    	$uri->setVar( 'testitem', 'imhere' );
    	$uri->delVars();
    	$value	=	$uri->getVar( 'testitem' );
    	$this->assertTrue( $value == null );
        
    }

    /**
     * @covers DunUri::setQuery
     * @depends testGetInstance
     */
    public function testSetQueryAsString( $uri )
    {
    	$uri->setQuery( 'item=a&something=b' );
    	$value = $uri->getVar( 'something' );
    	$this->assertTrue( $value == 'b' );
    }
    
    /**
     * @covers DunUri::setQuery
     * @depends testGetInstance
     */
    public function testSetQueryAsArray( $uri )
    {
    	$uri->setQuery( array( 'item' => 'a', 'something' => 'b' ) );
    	$value = $uri->getVar( 'something' );
    	$this->assertTrue( $value == 'b' );
    }

    /**
     * @covers DunUri::getQuery
     * @depends testGetInstance
     */
    public function testGetQueryAsString( $uri )
    {
        $value	=	$uri->getQuery();
        $this->assertTrue( is_string( $value ) );
        $this->assertContains( 'item', $value );
    }

    /**
     * @covers DunUri::getQuery
     * @depends testGetInstance
     */
    public function testGetQueryAsArray( $uri )
    {
        $value	=	$uri->getQuery( true );
        $this->assertTrue( is_array( $value ) );
        $this->assertArrayHasKey( 'item', $value );
    }
    
    /**
     * @covers DunUri::buildQuery
     */
    public function testBuildQueryNoArrayKey()
    {
    	$value	=	DunUri :: buildQuery( array( 'item' => 'a', 'something' => 'b' ) );
    	$this->assertContains( 'something', $value );
    }
    
    
    /**
     * @covers DunUri::buildQuery
     */
    public function testBuildQueryWithArrayKey()
    {
    	$value	=	DunUri :: buildQuery( array( 'item' => 'a', 'something' => 'b' ), 'akey' );
    	$this->assertContains( 'something', $value );
    	$this->assertContains( 'akey', $value );
    }

    /**
     * @covers DunUri::getScheme
     * @depends testGetInstance
     */
    public function testGetScheme( $uri )
    {
    	$value = $uri->getScheme();
    	$this->assertTrue( $value == 'https' );
    }

    /**
     * @covers DunUri::setScheme
     * @depends testGetInstance
     */
    public function testSetScheme( $uri )
    {
    	$uri->setScheme( 'ftp' );
    	$this->assertTrue( $uri->getScheme() == 'ftp' );
    	$uri->setScheme( 'https' );
    }

    /**
     * @covers DunUri::setUser
     * @depends testGetInstance
     */
    public function testSetUser( $uri )
    {
    	$uri->setUser( 'steven' );
    	$this->assertContains( 'steven', $uri->toString() );
    	return $uri;
    }
	
    /**
     * @covers DunUri::getUser
     * @depends testSetUser
     */
    public function testGetUser( $uri )
    {
    	$user = $uri->getUser();
    	$this->assertTrue( $user == 'steven' );
    }
    
    /**
     * @covers DunUri::setPass
     * @depends testGetInstance
     */
    public function testSetPass( $uri )
    {
        $uri->setPass( 'p@sSw0rD' );
    	$this->assertContains( 'p@sSw0rD', $uri->toString() );
    	return $uri;
    }

    /**
     * @covers DunUri::getPass
     * @depends testSetPass
     */
    public function testGetPass( $uri )
    {
    	$user = $uri->getPass();
    	$this->assertTrue( $user == 'p@sSw0rD' );
    }

    /**
     * @covers DunUri::setHost
     * @depends testGetInstance
     */
    public function testSetHost( $uri )
    {
    	$uri->setHost( 'jwhmcs.com' );
    	$this->assertContains( 'jwhmcs.com', $uri->toString() );
    	return $uri;
    }

    /**
     * @covers DunUri::getHost
     * @depends testSetHost
     */
    public function testGetHost( $uri )
    {
        $host = $uri->getHost();
        $this->assertTrue( $host == 'jwhmcs.com' );
    }

    /**
     * @covers DunUri::setPort
     * @depends testGetInstance
     */
    public function testSetPort( $uri )
    {
        $uri->setPort( '8080' );
        $this->assertContains( '8080', $uri->toString() );
        return $uri;
    }

    /**
     * @covers DunUri::getPort
     * @depends testSetPort
     */
    public function testGetPort( $uri )
    {
        $port = $uri->getPort();
        $this->assertTrue( $port == '8080' );
    }

    /**
     * @covers DunUri::setPath
     * @depends testGetInstance
     */
    public function testSetPath( $uri )
    {
        $uri->setPath( 'new/path/to/file.php' );
        $this->assertContains( 'path/to/file.php', $uri->toString() );
        return $uri;
    }

    /**
     * @covers DunUri::getPath
     * @depends testSetPath
     */
    public function testGetPath( $uri )
    {
        $path = $uri->getPath();
        $this->assertTrue( $path == 'new/path/to/file.php' );
    }

    /**
     * @covers DunUri::setFragment
     * @depends testGetInstance
     */
    public function testSetFragment( $uri )
    {
        $uri->setFragment( 'herenow' );
        $this->assertContains( '#herenow', $uri->toString() );
        return $uri;
    }

    /**
     * @covers DunUri::getFragment
     * @depends testSetFragment
     */
    public function testGetFragment( $uri )
    {
        $frag = $uri->getFragment();
        $this->assertTrue( $frag == 'herenow' );
    }

    /**
     * @covers DunUri::isFragment
     */
    public function testIsFragment()
    {
    	$uri = DunUri :: getInstance( '#herego' );
        $this->assertTrue( $uri->isFragment() );
        
        $uri = DunUri :: getInstance( 'http://www.jwhmcs.com/test.php' );
        $this->assertFalse( $uri->isFragment() );
    }

    /**
     * @covers DunUri::isSSL
     * @depends testGetInstance
     */
    public function testIsSSL( $uri )
    {
        $ssl = $uri->isSSL();
        $this->assertTrue( $ssl );
    }

    /**
     * @covers DunUri::isInternal
     */
    public function testIsInternal()
    {
        $this->assertTrue( DunUri :: isInternal( 'test/path/to/file.php' ) );
        $this->assertFalse( DunUri :: isInternal( 'http://localhost.com/test/path/to/file.php' ) );
    }
}

