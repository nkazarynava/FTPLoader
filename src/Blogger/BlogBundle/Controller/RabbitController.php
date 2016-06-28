<?php
namespace Blogger\BlogBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 6/28/2016
 * Time: 13:26
 */
class RabbitController extends Controller
{

    public function indexAction()
    {
        $test = 'testMsg1';
       $this->get('old_sound_rabbit_mq.hello_world_producer')->publish($test);
        return new Response('123');
    }
}