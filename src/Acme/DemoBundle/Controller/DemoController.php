<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\DemoBundle\Lib\UrbanAirship\Push\BlackberryNotification;
use Acme\DemoBundle\Lib\UrbanAirship\Device\BlackberryDevice;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Acme\DemoBundle\Form\ContactType;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

//Urban AirShit
//use UrbanAirship\Client;
use Acme\DemoBundle\Lib\UrbanAirship\Client;

class DemoController extends Controller
{
    /**
     * @Route("/", name="_demo")
     * @Template()
     */
    public function indexAction()
    {

        return array();
    }

    /**
     * @Route("/hello/{name}", name="_demo_hello")
     * @Template()
     */
    public function helloAction($name)
    {
        return array('name' => $name);
    }

    /**
     * @Route("/contact", name="_demo_contact")
     * @Template()
     */
    public function contactAction()
    {
        $form = $this->get('form.factory')->create(new ContactType());

        $request = $this->get('request');
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $mailer = $this->get('mailer');
                // .. setup a message and send it
                // http://symfony.com/doc/current/cookbook/email.html

                $this->get('session')->setFlash('notice', 'Message sent!');

                return new RedirectResponse($this->generateUrl('_demo'));
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/demo", name="_demo_contact")
     * @Template()
     */
    public function demoAction() {
        $cliente = new Client("Application Secret","Application Master Secret");

        $dispositivo = new BlackberryDevice('XXXXXXX');
        $dispositivo->setAlias('Luke Skywalker')->addTag('republic')->addTag('pilot');

        $notificacion = new BlackberryNotification();
        $notificacion->addDevice($dispositivo);
        $notificacion->setBody("hola caracola");
        $notificacion->setContentType('text/plain');
        $cliente->push($notificacion);
        /*// Simple notification, with device
            $device = new AppleDevice('FE66489F304DC75B8D6E8200DFF8A456E8DAEACEC428B427E9518741C92C6660');
            $device->setAlias('Luke Skywalker')->addTag('republic')->addTag('pilot');

            $notification = new AppleNotification();
            $notification->addDevice($device);
            $notification->setAlert('Hey dude!');
            $notification->setBadge(1);
            $client->push($notification);
        */
        return $this->render('AcmeDemoBundle:Welcome:demo.html.twig');
    }
}
