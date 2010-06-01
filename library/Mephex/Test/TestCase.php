<?php



/**
 * The class and file name do not match as the auto-loader
 * would expect, so we must load it manually
 */
require_once 'PHPUnit/Framework.php';


 
/**
 * 
 * NOTE: we declare the class abstract so that PHPUnit will not 
 * try to run the class as its own independent unit test case.
 * Only (non-abstract) sub classes will be ran as unit tests.
 * 
 * @author mlight
 */
abstract class Mephex_Test_TestCase
extends PHPUnit_Framework_TestCase
{
}  