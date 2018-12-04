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
                    'oauth_consumer_key'    => 'domik-mechti-https',
                    'oauth_consumer_secret' => 'ktZDhV1NOo.faV4AUiMltWAlzCYwZi',
                    'oauth_token'           => 'fQM41va5Jyyh1dZf6IcMM.Zgu9xY5xDrHDNX9eOd',
                    'oauth_token_secret'    => '.cexpbNAo9EnC4s591vGc3eRWwDsx2S4rCMHumpM',
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
