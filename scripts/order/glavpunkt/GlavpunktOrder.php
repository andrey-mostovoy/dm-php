<?php

require '../../UApiRequest.php';

header('Content-Type: application/json; charset= utf-8');

/**
 * Класс описания создания заказа в системе главпункта.
 */
class GlavpunktOrder extends UApiRequest {
    public function create() {
        $response = $this->getRequest()->get('/shop/invoices/', array(
            'id' => '360',
        ));

        echo $response;
    }
}

$Manger = new GlavpunktOrder();
$Manger->create();

?>
