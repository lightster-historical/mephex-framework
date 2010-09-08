<?php



class Mephex_Model_Stream_WriterTest
extends Mephex_Test_TestCase
{
	public function testAbstractClassIsExtendable()
	{
		$object	= new Stub_Mephex_Model_Stream_Writer();

		$this->assertTrue($object instanceof Mephex_Model_Stream_Writer);
	}
}  