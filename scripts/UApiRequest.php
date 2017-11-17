<?php

require 'uAPImodule.php';

/**
 * Класс описания презентера подарков для страницы акций.
 */
class UApiRequest {
    /**
     * @var Request
     */
    private $Request;

    /**
     * @return Request
     */
    protected function getRequest() {
        if (!$this->Request) {
            $this->Request = new Request(
                array(
                    'oauth_consumer_key'    => 'domik-mechti',
                    'oauth_consumer_secret' => 'Mn1fZTL6MPLsuhPE1XizupTyuYtpAZ',
                    'oauth_token'           => 'pitVP00Mg1BuTgy3mkWb1PNb7HuBrSX45Nbg9sGS',
                    'oauth_token_secret'    => 'gqUlD50YqlKWUo7dC2QkGFtYiykSkZeuM0NCPyyM'
                )
            );
        }

        return $this->Request;
    }

    /**
     * Возвращает ид юзера на сайте. Для гостя - 0.
     * @return int
     */
    protected function getUserId() {
        return ucoz_getinfo('SITEUSERID');
    }
}

?>
