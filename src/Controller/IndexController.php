<?php
namespace MyModule\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http;
use Zend\Http\Header\Location;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return array(
            'foo' => 'bar'
        );
    }

    public function modelAction()
    {
        return new ViewModel(array(
            'bar' => 'foo'
        ));
    }

    public function deniedResponseAction()
    {
        $response = new Http\Response();
        $response->setStatusCode(Http\Response::STATUS_CODE_403)
                 ->setContent('Permission denied');
        return $response;
    }

    public function redirectResponseAction()
    {
        $response = new Http\Response();
        $response->setStatusCode(Http\Response::STATUS_CODE_302)
                 ->getHeaders()->addHeader(new Location('/home'));
        return $response;
    }
}
