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
    private $_doctrine;
    public function __construct($doctrine)
    {
        $this->_doctrine = $doctrine;
    }
    public function execute(AMQPMessage $msg) {
        $request = Request::createFromGlobals();
        $testRole = $this->_doctrine->getRepository('BloggerBlogBundle:Role')
            ->find(3);
        $sRole = $testRole->getRole();
        $this->_doctrine->getManager()->getConnection()->close();
        //$entityManager->
        //var_dump($this->_em);
        //$sTest = $request->getUri();
        echo "Hello $sRole $msg->body!".PHP_EOL;
    }
}