<?php



class Mephex_Model_Stream_ReaderTest
extends Mephex_Test_TestCase
{
	public function testAbstractClassIsExtendable()
	{
		$object	= new Stub_Mephex_Model_Stream_Reader();

		$this->assertTrue($object instanceof Mephex_Model_Stream_Reader);
	}
}  