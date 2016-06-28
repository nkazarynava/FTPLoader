<?php
/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 6/28/2016
 * Time: 13:13
 */
namespace Blogger\BlogBundle\Rabbit;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\HttpFoundation\Request;


class HelloWorldConsumer implements ConsumerInterface {
    public function execute(AMQPMessage $msg) {
        $request = Request::createFromGlobals();
        $sTest = $request->getPathInfo();
       // $request->getBaseUrl();
        echo "Hello $sTest . $msg->body!".PHP_EOL;
    }
}