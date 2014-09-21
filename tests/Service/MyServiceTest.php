<?php
namespace MyModuleTest\Service;

use MyModule\Service\MyService;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\EventManager\Event;
use Zend\EventManager\EventManager;

class MyServiceTest extends TestCase
{
    /**
     * @var MyService
     */
    private $myService;

    public function setUp()
    {
        $this->myService = new MyService();
        $this->myService->setEventManager(new EventManager());
    }

    public function testFooEventIsTriggeredWhenCallingFoo()
    {
        // With no event handler the event is not triggered
        $fooIsTriggered = false;
        $this->myService->foo();
        $this->assertFalse($fooIsTriggered);

        // Add an event handler
        $test = $this;
        $this->myService->getEventManager()->attach(
            'foo',
            function (Event $e) use (&$fooIsTriggered, $test) {
                $fooIsTriggered = true;
                // Check the param 'argument' exists with the correct value
                $test->assertEquals('foo', $e->getParam('argument'));
            }
        );
        $this->myService->foo();
        // Check the event was triggered
        $this->assertTrue($fooIsTriggered);
    }

    public function testBarEventIsTriggeredWhenCallingBar()
    {
        // With no event handler the event is not triggered
        $barIsTriggered = false;
        $this->myService->bar();
        $this->assertFalse($barIsTriggered);

        // Add an event handler
        $test = $this;
        $this->myService->getEventManager()->attach(
            'bar',
            function (Event $e) use (&$barIsTriggered, $test) {
                $barIsTriggered = true;
                // Check the param 'argument' exists with the correct value
                $test->assertEquals('bar', $e->getParam('argument'));
            }
        );
        $this->myService->bar();
        // Check the event was triggered
        $this->assertTrue($barIsTriggered);
    }
}
