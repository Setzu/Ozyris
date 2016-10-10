<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 03/10/16
 * Time: 13:29
 */

namespace tests\Ozyris\Service;


use Ozyris\Service\Dispatch;
use Ozyris\Test\TestCase;

class DispatchTest extends TestCase
{

    /**
     * setUp
     */
    public function setUp()
    {
        $this->instance = new Dispatch();
    }

    /**
     * tearDown
     */
    public function tearDown()
    {
        $this->instance = null;
    }

    /**
     * Test des valeurs par défaut du ControllerName et de l'ActionName
     * testInitialState
     */
    public function testInitialState()
    {
        $this->assertEquals('indexController', $this->instance->getControllerName());
        $this->assertEquals('indexAction', $this->instance->getActionName());
    }

    /**
     * Test du Set et du Get du ControllerName et de l'ActionName
     * testGetSetControllerAndActionName
     */
    public function testGetSetControllerAndActionName()
    {
        $aParametersFixture = ['test'];

        $this->assertSame($this->instance, $this->callInaccessibleMethod('setControllerName', $aParametersFixture));
        $this->assertSame($this->instance, $this->callInaccessibleMethod('setActionName', $aParametersFixture));

        $this->assertEquals($aParametersFixture[0] . 'Controller', $this->instance->getControllerName());
        $this->assertEquals($aParametersFixture[0] . 'Action', $this->instance->getActionName());
    }

    public function testDispatch()
    {
        $this->instance = $this->createMock(Dispatch::class);
        $sDataFixture = 'data';

        if (isset($_GET['controller'])) {
            $this->instance->expects($this->once())->method('setControllerName')->with($sDataFixture);
        } else {
            $this->instance->expects($this->never())->method('setControllerName');
        }

        if (isset($_GET['action'])) {
            $this->instance->expects($this->once())->method('setActionName')->with($_GET['action']);
        } else {
            $this->instance->expects($this->never())->method('setActionName');
        }

        $this->instance->expects($this->once())->method('getControllerName');
        $this->instance->expects($this->once())->method('getActionName');

//        $this->assertInstanceOf($sControllerFixture, $this->instance->dispatch());

//        $oControllerMock = $this->createMock($sControllerFixture);
//        $oControllerMock->expects($this->once())->method($sActionfixture);
    }
}
