<?php

require 'GlavpunktAPI.php';
require '../../UApiRequest.php';

//header('Content-Type: application/json; charset= utf-8');

/**
 * Класс описания создания заказа в системе главпункта.
 */
class GlavpunktOrder extends UApiRequest {
    private $login = 'domikm';
    private $token = '9ddca6f6080010662606d00766b3a0a3';

    public function handleRequest() {
        switch ($_POST['method']) {
            case 'url':
                return $this->getRequestUrl();
                break;
            case 'orderUrl':
                return $this->getRequestOrderUrl();
                break;
            case 'order':
                return $this->makeOrder();
                break;
            default:
                return '';
        }
    }

    private function getRequestUrl() {
        $params = array();
        if (isset($_POST['ids'])) {
            $params['id'] = $_POST['ids'];
        }
        $response = $this->getRequest()->createGetUrl('/shop/invoices/', $params);
        return $response;
    }

    private function makeOrder() {
        $orderData = json_decode(str_replace('\\', '', $_POST['orderData']), true);
        $GlavpunktApi = new GlavpunktAPI($this->login, $this->token);
        $res = $GlavpunktApi->take_pkgs($orderData);

        return json_encode($res);
    }

    public function getRequestOrderUrl() {
        return $this->getRequest()->createGetUrl('/shop/order/', array(
            'order' => $_POST['orderHash'],
        ));
    }
}

$Manger = new GlavpunktOrder();
echo $Manger->handleRequest();

?>
