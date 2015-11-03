<?php

/* Bootstrap! */
require dirname( dirname( __DIR__ ) ) . DIRECTORY_SEPARATOR . 'bootstrap.php';


/**
 * Test class for DunLanguage.
 * Generated by PHPUnit on 2013-10-17 at 11:18:11.
 */
class DunLanguageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var DunLanguage
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
    	
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers DunLanguage::getInstance
     */
    public function testGetInstance()
    {
    	get_dunamis( 'dunamis' );
    	$language	=	dunloader( 'language' );
    	$this->assertTrue( $language !== null, 'Loader did not return an object' );
    	$this->assertTrue( is_object( $language ) );
    	$this->assertInstanceOf( 'DunLanguage', $language );
    	return $language;
    }
    
    
	/**
	 * 
	 * @covers DunLanguage::appendTranslations
	 * @depends testGetInstance
	 */
    public function testAppendTranslations( $language )
    {
    	$language->appendTranslations( array( 'test.item' => 'This is a new translation' ), 'dunamis' );
    	$this->assertTrue( $language->translate( 'dunamis.test.item' ) == 'This is a new translation');
    }

	/**
	 * @covers DunLanguage::getIdiom
	 * @depends testGetInstance
	 */
	public function testGetIdiom( $language )
	{
		$this->assertTrue( $language->getIdiom() == 'english' );
	}
	
	
	/**
	 * @covers DunLanguage::loadLanguage
	 */
	public function testLoadLanguage()
	{
		get_dunamis();
		$language	=	dunloader( 'language', false );
		$this->assertTrue( $language->translate( 'dunamis.config.title' ) == 'Dunamis Framework' );
	}
	
	
	/**
	 * @covers DunLanguage::setIdiom
	 * @depends testGetInstance
	 */
	public function testSetIdiom( $language )
	{
		$language->setIdiom( 'Spanish' );
		$this->assertAttributeContains( 'spanish', '_idiom', $language );
	}
	
	
	/**
	 * @covers DunLanguage::translate
	 * @depends testGetInstance
	 */
	public function testTranslate( $language )
	{
		$this->assertTrue( $language->translate( 'dunamis.config.title' ) == 'Dunamis Framework' );
	}
}

?>