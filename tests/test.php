<?php


class test extends PHPUnit_Framework_TestCase
{
	
	public function testGet_dunamis_is_object()
	{
		$dunamis	=	get_dunamis();
		$this->assertTrue( $dunamis !== null );
		$this->assertTrue( $dunamis !== false );
		return $dunamis;
	}
	
}