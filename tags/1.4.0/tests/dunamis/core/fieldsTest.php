<?php

/* Bootstrap! */
require dirname( dirname( __DIR__ ) ) . DIRECTORY_SEPARATOR . 'bootstrap.php';


/**
 * Test class for DunFields.
 * Generated by PHPUnit on 2013-10-17 at 21:18:32.
 */
class DunFieldsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var DunFields
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
    	get_dunamis( 'dunamis' );
    	
    	$field = array(
    				'name' => 'customitem',
    				'order'	=> 10,
					'type' => 'text',
					'value' => 'a usable value here',
					'label' => 'dunamis.admin.form.group.label.name',
					'description' => 'dunamis.admin.title',
    				'validation' => 'testvalidation',
    				'junkitem'	=> 'junk'
				);
    	
        $this->object = new DunFields( $field );
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
	 * @covers DunFields::__call
	 */
	public function testSetVariable()
	{
		$this->object->setTarget( 'value' );
		$this->object->setTest( 'test' );
		$this->assertAttributeContains( 'value', '_target', $this->object );
		$this->assertAttributeContains( 'test', '_test', $this->object );
		return $this->object;
	}
	
	
	/**
	 * @covers DunFields::__call
	 * @depends testSetVariable
	 */
	public function testHasVariable( $update )
	{
		$value = $update->hasTarget();
		$this->assertTrue( $value );
		
		$value = $update->hasTest();
		$this->assertTrue( $value );
		
		$this->assertFalse( $update->hasNothing() );
		return $update;
	}
	
	
	/**
	 * @covers DunFields::__call
	 * @depends testSetVariable
	 */
	public function testGetVariable( $update )
	{
		$value = $update->getTarget();
		$this->assertTrue( $value == 'value' );
		
		$value = $update->getTest();
		$this->assertTrue( $value == 'test' );
		
		$this->assertFalse( $update->getNodesc() );
		
		$this->assertContains( 'junk', $update->getJunkitem() );
		return $update;
	}

    /**
     * @covers DunFields::getDescription
     * @depends testSetVariable
     */
    public function testGetDescription( $update )
    {
    	$value	=	$update->getDescription();
    	$this->assertContains( 'Dunamis Framework', $value );
    	$this->assertContains( '<div', $value );
    }
    
    
    /**
     * @covers DunFields::getId
     * @depends testSetVariable
     */
    public function testGetId( $update )
    {
    	$id = $update->getId();
    	$this->assertContains( 'custom', $id );
    	$this->assertTrue( $id == 'customitem' );
    }

    /**
     * @covers DunFields::getValue
     * @depends testSetVariable
     */
    public function testGetValue( $update )
    {
    	$this->assertContains( 'usable', $update->getValue() );
    	
    	$update->setValue( '"test"' );
    	$this->assertTrue( '&quot;test&quot;' == $update->getValue() );
    }

    /**
     * @covers DunFields::getLabel
     * @depends testSetVariable
     */
    public function testLabel( $update )
    {
    	$this->assertContains( '<label for="customitem"', $update->getLabel() );
    }

    /**
     * @covers DunFields::setAttribute
     * @depends testSetVariable
     */
    public function testSetAttribute( $update )
    {
    	$update->setTestattribute( 'value', true );
    	
    	$this->assertTrue( $update->getTestattribute() == 'value' );
    }   
}