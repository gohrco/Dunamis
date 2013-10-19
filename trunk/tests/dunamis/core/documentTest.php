<?php

/* Bootstrap! */
require dirname( dirname( __DIR__ ) ) . DIRECTORY_SEPARATOR . 'bootstrap.php';


/**
 * Test class for DunDocument.
 * Generated by PHPUnit on 2013-10-18 at 16:22:43.
 */
class DunDocumentTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var DunDocument
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
    	get_dunamis( 'dunamis' );
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers DunDocument::getInstance
     */
    public function testGetInstance()
    {
    	get_dunamis( 'dunamis' );
    	$doc	=	dunloader( 'document' );
    	$this->assertTrue( $doc !== null, 'Loader did not return an object' );
    	$this->assertTrue( is_object( $doc ) );
    	$this->assertInstanceOf( 'DunDocument', $doc );
    	return $doc;
    }
	
	
	/**
	 * @covers DunDocument::addScript
	 * @depends testGetInstance
	 */
	public function testAddScript( $doc )
	{
		$doc->addScript( 'test.js' );
		$scripts	=	$doc->getScripts();
		
		$this->assertArrayHasKey( 'test.js', $scripts );
		$scripts	=	$scripts['test.js'];
		
		$this->assertArrayHasKey( 'mime', $scripts );
		
		return $doc;
	}

    /**
     * @covers DunDocument::addScriptDeclaration
     * @depends testGetInstance
     */
    public function testAddScriptDeclaration( $doc )
    {
    	$doc->addScriptDeclaration( 'jQuery("#test").val();' );
    	$scr	=	$doc->getScript();
    	
    	$this->assertArrayHasKey( 'text/javascript', $scr );
    	$scr	=	$scr['text/javascript'];
    	
    	$this->assertContains( '#test', $scr );
    	
    	return $doc;
    }

    /**
     * @covers DunDocument::addStyleSheet
     * @depends testGetInstance
     */
	public function testAddStyleSheet( $doc )
	{
		$doc->addStyleSheet( 'test.css' );
		$ss	=	$doc->getStylesheets();
		
		$this->assertArrayHasKey( 'test.css', $ss );
		$ss	=	$ss['test.css'];
		
		$this->assertArrayHasKey( 'mime', $ss );
		$this->assertTrue( $ss['mime'] == 'text/css' );
		return $doc;
	}

    /**
     * @covers DunDocument::addStyleDeclaration
     * @depends testGetInstance
     */
	public function testAddStyleDeclaration( $doc )
	{
		$doc->addStyleDeclaration( '.main { color: #000000; }' );
		$st	=	$doc->getStyle();
		
		$this->assertArrayHasKey( 'text/css', $st );
		$st	=	$st['text/css'];
		 
		$this->assertContains( '#000000;', $st );
		
		return $doc;
	}

    /**
     * @covers DunDocument::renderHeadData
     * @depends testGetInstance
     */
	public function testRenderHeadData( $doc )
	{
		$doc->addScript( 'test.js' );
		$doc->addScriptDeclaration( 'jQuery("#test").val();' );
		$doc->addStyleSheet( 'test.css' );
		$doc->addStyleDeclaration( '.main { color: #000000; }' );
		
		$head	=	$doc->renderHeadData();
		
		$this->assertContains( '<style type="text/css">', $head );
		$this->assertContains( '<script type="text/javascript">', $head );
		$this->assertContains( '.main { color: #000000; }', $head );
	}
}
?>
