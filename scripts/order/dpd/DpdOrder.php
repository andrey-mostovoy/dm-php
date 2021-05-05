<?php

require 'DpdClient.php';
require '../../UApiRequest.php';

class DpdOrder extends UApiRequest {

    /**
     * @var DpdClient
     */
    private $DpdClient;

    public function __construct() {
        $this->DpdClient = new DpdClient();
    }

    public function handleRequest() {
        switch ($_POST['method']) {
            case 'test':
                return $this->methodTest();
                break;
            default:
                return '';
        }
    }

    private function methodTest() {
        return $this->DpdClient->getPoints(array(

        ));
    }
}

$Manger = new DpdOrder();
echo $Manger->handleRequest();

?>

