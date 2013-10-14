<?php



require_once 'C:\xampp\www\mods\whmcs\includes\dunamis.php';



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

    public function test__constructor()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    public function testDisplayErrors()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    public function testGetModulePath()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    public function testInitialise()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    public function testLoadEnvironment()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    public function testLoadModule()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    public function testSetError()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }
}