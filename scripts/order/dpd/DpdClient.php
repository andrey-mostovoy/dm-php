<?php

class DpdClient {

    /**
     * География DPD
     *
     * @var string
     */
    private $serviceGeo = 'geography2';

    /**
     * Расчет стоимости
     *
     * @var string
     */
    private $serviceCalculator = 'calculator2';

    /**
     * Создание/изменение/отмена заказа
     *
     * @var string
     */
    private $serviceOrder = 'order2';

    // Данные для тестового сервера:
    private $urlTemplate = 'http://wstest.dpd.ru/services/%s?wsdl';
    private $id          = 1001027795;
    private $key         = '182A17BD6FC5557D1FCA30FA1D56593EB21AEF88';

    // Данные для прод сервера:
//    private $urlTemplate = 'http://ws.dpd.ru/services/%s?wsdl';
//    private $id = 1001027795;
//    private $key = '182A17BD6FC5557D1FCA30FA1D56593EB21AEF88';

    private function post($service, $data = array()) {
        // РАБОЧИЙ ВАРИАНТ с рабочим SOAP
//        $client = new SoapClient("http://wstest.dpd.ru/services/geography2?wsdl");
//        return $client->getCitiesCashPay([
//            'request' => [
//                'auth' => [
//                    'clientNumber' => 1001027795,
//                    'clientKey' => '182A17BD6FC5557D1FCA30FA1D56593EB21AEF88',
//                ],
//            ],
//
//                                       ]);

        // А это вариант с REST с запросами к SOAP серверу и парсингом xml
        $soapUrl = 'http://wstest.dpd.ru/services/geography2?wsdl';

        // xml post structure
        $xmlPostString = <<<STR
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://dpd.ru/ws/geography/2015-05-20">
    <SOAP-ENV:Body>
        <ns1:getCitiesCashPay>
            <request>
                <auth>
                    <clientNumber>{$this->id}</clientNumber>
                    <clientKey>{$this->key}</clientKey>
                </auth>
            </request>
        </ns1:getCitiesCashPay>
    </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
STR;

        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
//            "Cache-Control: no-cache",
//            "Pragma: no-cache",
            "Content-length: " . strlen($xmlPostString),
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $soapUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlPostString);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);

        // convertingc to XML
        $Xml = simplexml_load_string($response);
        $namespaces = $Xml->getNamespaces(true);
        return $Xml->children($namespaces['S'])->children($namespaces['ns2'])->children();
    }

    public function getPoints($data = array()) {
        return json_encode($this->post($this->serviceGeo, $data));
    }

    public function getOrderPrice($data = array()) {
        return $this->post($this->serviceCalculator, $data);
    }
}
