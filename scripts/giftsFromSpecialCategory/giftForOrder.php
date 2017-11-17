<?php

require '../UApiRequest.php';
require 'Gift.php';

$___notjson = 1;
header('Content-Type: application/json; charset= utf-8');

/**
 * Класс описания подарка.
 */
class GiftInOrder extends Gift {
    /**
     * @var bool Признак доступного выбора подарка.
     */
    public $isEnabled = false;

    /**
     * @var bool Признак удаления подарка из корзины по какой-либо причине.
     */
    public $isDeleted = false;

    /**
     * @var int Ид товара в заказе.
     */
    public $idInOrder = 0;

    /**
     * @var int Ид товара.
     */
    public $entryId = 0;
}

/**
 * Класс описания презентера подарка. Определяется, нужно ли показать блок с выбором подарка, а также
 * передает на клиент информацию про ид подарка в заказе для его ограничения по количеству. Также определяет
 * и выполняет удаление из корзины подарка если сумма стала ниже пороговой.
 */
class GiftPresenter extends UApiRequest {
    /**
     * Лимит суммы для разблокирования подарка.
     */
    const MONEY_LIMIT = 2000;

    /**
     * @var GiftInOrder
     */
    private $Gift;

    /**
     * @var int Сумма всего заказа в корзине.
     */
    private $totalOrderSum = 0;

    public function __construct() {
        $this->process();
    }

    /**
     * Возвращает текущий заказ в корзине.
     * @return array
     */
    private function getBasketOrder() {
        $response = $this->getRequest()->get('/shop/basket/');
        return json_decode($response, true);
    }

    /**
     * Удаляет подарок из корзины.
     */
    private function deleteGiftFromBasket() {
        $this->getRequest()->delete('/shop/basket/', array(
            'id' => $this->Gift->idInOrder,
        ));

        $this->Gift->isEnabled = false;
        $this->Gift->isDeleted = true;
    }

    /**
     * Основная обработка логики модуля.
     */
    private function process() {
        $response = $this->getBasketOrder();
        var_dump($response);
        die;
        $this->Gift = new GiftInOrder();

        if (isset($response['success']['basket']['items'])) {
            $items = $response['success']['basket']['items'];

            foreach ($items as $item) {
                $this->totalOrderSum += $item['summ']['summ_raw'];
                if ($item['entry_cat_id'] == GiftInOrder::CATEGORY_ID) {
                    $this->Gift->idInOrder = $item['id'];
                    $this->Gift->entryId = $item['entry_id'];
                }
            }

            // сумма заказа более пороговой и подарка нет в корзине.
            $this->Gift->isEnabled = ($this->totalOrderSum >= self::MONEY_LIMIT) && !$this->Gift->idInOrder;

            // Подарок в корзине, а сумма заказа ниже нужного порога.
            if ($this->Gift->idInOrder && $this->totalOrderSum < self::MONEY_LIMIT) {
                $this->deleteGiftFromBasket();
            }
        }
    }

    /**
     * Возвращает представление данных для клиента.
     * @return string
     */
    public function getViewData() {
        return json_encode(
            array(
                'giftEnabled' => $this->Gift->isEnabled,
                'isDeleted'   => $this->Gift->isDeleted,
                'giftId'      => $this->Gift->idInOrder,
            )
        );
    }
}

$GiftPresenter = new GiftPresenter();
echo $GiftPresenter->getViewData();

?>
