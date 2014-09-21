<?php
namespace MyModuleTest\Controller;

use MyModule\Controller\IndexController;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\Http;

class IndexControllerTest extends TestCase
{
    /**
     * @var IndexController
     */
    private $indexController;

    public function setUp()
    {
        $this->indexController = new IndexController();
    }

    public function testIndexAction()
    {
        $resp = $this->indexController->indexAction();
        $this->assertTrue(is_array($resp));
        $this->assertArrayHasKey('foo', $resp);
        $this->assertEquals('bar', $resp['foo']);
    }

    public function testModelAction()
    {
        $resp = $this->indexController->modelAction();
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $resp);
        $this->assertEquals('foo', $resp->getVariable('bar'));
        // Check a nonexistent variable in the model
        $this->assertNull($resp->getVariable('nonexistent'));
    }

    public function testDeniedResponseAction()
    {
        $resp = $this->indexController->deniedResponseAction();
        $this->assertInstanceOf('Zend\Http\Response', $resp);
        $this->assertEquals(Http\Response::STATUS_CODE_403, $resp->getStatusCode());
        $this->assertEquals('Permission denied', $resp->getContent());
    }

    public function testRedirectResponseAction()
    {
        $resp = $this->indexController->redirectResponseAction();
        $this->assertInstanceOf('Zend\Http\Response', $resp);
        $this->assertEquals(Http\Response::STATUS_CODE_302, $resp->getStatusCode());
        $headers = $resp->getHeaders()->toArray();
        $this->assertArrayHasKey('Location', $headers);
        $this->assertEquals('/home', $headers['Location']);
    }
}
