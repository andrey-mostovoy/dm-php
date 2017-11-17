 <?php $___notjson=1; header('Content-Type: text/html; charset= utf-8');
 /**
 * Набор методов для запроса к API uCoz. Версия для uCoz PHP сервера
 * @author Dmitry Kiselev <api@ucoz.net> – Демонстрация обращения к uAPImodule.php
 * @version 2.1 от 8 августа 2016 – сделан фикс по ssl
 */

 require 'uAPImodule.php';
 $request = new Request(array(
 	'oauth_consumer_key'    => 'ключ',
 	'oauth_consumer_secret' => 'ключ',
 	'oauth_token'           => 'ключ',
 	'oauth_token_secret'    => 'ключ'
 	));
 $response = $request->get('/my', array(
//различные параметры, если нужно
 	));
    json_encode($response); //Получаем ответ
    print_r($response);

