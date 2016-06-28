<?php
namespace Blogger\BlogBundle\Rabbit;
use OldSound\RabbitMqBundle\RabbitMq\Producer;

/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 6/28/2016
 * Time: 14:33
 */
class HelloProducer extends Producer {
    public function publish($msgBody, $routingKey = '', $additionalProperties = array()) {
        $msgBody = serialize($msgBody);
        parent::publish($msgBody, $routingKey, $additionalProperties);
    }
}