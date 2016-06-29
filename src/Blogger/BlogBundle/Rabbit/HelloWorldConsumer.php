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

        $id = spl_object_hash($this->_doctrine);
        $testRole = $this->_doctrine->getRepository('BloggerBlogBundle:Role')
            ->find(3);
        $sRole = $testRole->getRole();
        $this->_doctrine->getManager()->getConnection()->close();

        //start testing curl
        $url = "http://ftpupload.com?test=START";
        $options = array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,   // return web page
            CURLOPT_HEADER         => false,  // don't return headers
            CURLOPT_FOLLOWLOCATION => true,   // follow redirects
            CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
            CURLOPT_ENCODING       => "",     // handle compressed
            CURLOPT_USERAGENT      => "test", // name of client
            CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
            CURLOPT_TIMEOUT        => 120,    // time-out on response
        );

        //??????? ????? cURL-????????????
        $mh = curl_multi_init();
        //for saving links to resources (of type resource) created below
        $handles = array();
        $process_count = 15;

        while ($process_count--)
        {
            $options[CURLOPT_URL] = $url.$process_count;
            $ch = curl_init();
            curl_setopt_array($ch, $options);
            curl_multi_add_handle($mh, $ch);
            $handles[] = $ch;
        }

        $running=null;
        $time_start = microtime(true);
        do
        {
            curl_multi_exec($mh, $running);
        }
        while ($running > 0);
        $time_end = microtime(true);
        for($i = 0; $i < count($handles); $i++)
        {
            $out = curl_multi_getcontent($handles[$i]);
            print $out . "\r\n";
            curl_multi_remove_handle($mh, $handles[$i]);
        }
        $execution_time = ($time_end - $time_start);

        curl_multi_close($mh);


         //$filePath = __FILE__;
         //$aPath = pathinfo($filePath);

        echo "Hello $id _ $sRole $msg->body!".$execution_time.PHP_EOL;

    }

}
