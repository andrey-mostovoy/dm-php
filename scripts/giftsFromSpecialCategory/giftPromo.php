<?php

require '../UApiRequest.php';
require 'Gift.php';

$___notjson = 1;
header('Content-Type: application/json; charset= utf-8');

/**
 * Класс описания подарка.
 */
class GiftPromo extends Gift {

}

/**
 * Класс описания презентера подарков для страницы акций.
 */
class GiftPromoPresenter extends UApiRequest {
    /**
     * @var GiftPromo[] Массив с подарками.
     */
    private $gifts = array();

    public function __construct() {
        $this->process();
    }

    /**
     * Возвращает все подарки.
     * @return array
     */
    private function getAllGifst() {
        $response = $this->getRequest()->get('/shop/cat/', array(
            'cat_uri' => 'podarki',
        ));
        return json_decode($response, true);
    }

    /**
     * Основная обработка логики модуля.
     */
    private function process() {
        $response = $this->getAllGifst();
        var_dump($response);

        if (!isset($response['success']['goods_list'])) {
            return;
        }
    }

    /**
     * Возвращает представление данных для клиента.
     * @return string
     */
    public function getViewData() {
        return json_encode(
            array(
//                'giftEnabled' => $this->Gift->isEnabled,
//                'isDeleted'   => $this->Gift->isDeleted,
//                'giftId'      => $this->Gift->idInOrder,
            )
        );
    }
}

$GiftPresenter = new GiftPromoPresenter();
echo $GiftPresenter->getViewData();

?>
