<?php

namespace App\Service;

use OpenPayU_Configuration;
use OpenPayU_Order;

class PaymentService
{
    public function __construct()
    {
     
        OpenPayU_Configuration::setEnvironment($_ENV['PAYU_ENV']);

        OpenPayU_Configuration::setMerchantPosId($_ENV['PAYU_POS_ID']);
        OpenPayU_Configuration::setSignatureKey($_ENV['PAYU_MD5']);
        OpenPayU_Configuration::setOauthClientId($_ENV['PAYU_CLIENT_ID']);
        OpenPayU_Configuration::setOauthClientSecret($_ENV['PAYU_CLIENT_SECRET']);
    } 

    public function createPayment($order)
    {
        //dd($order);

        $billingAddress = $order->getBillingAddress();
        $orderItems = $order->getOrderItems();
        
        $products = [];
        $totalAmount = 0;
        foreach ($orderItems as $orderItem) {
            $price = $orderItem->getUnitPrice() * $orderItem->getQuantity();
            $totalAmount += $price;
            array_push($products,[
                'name'=>$orderItem->getProductName(),
                'unitPrice' => $orderItem->getUnitPrice(),
                'quantity' => $orderItem->getQuantity()
            ]);
        }
       // dd($totalAmount);
        $paymentData = [
            'continueUrl' => 'http://localhost:3000/podsumowanie',
            'notifyUrl' => 'https://your-shop.com/api/payment/notify',
            'description' => 'Order from sabirex.pl',
            'currencyCode' => 'PLN',
            'customerIp' => $_SERVER['REMOTE_ADDR'],
            'merchantPosId' => $_ENV['PAYU_POS_ID'],
            'totalAmount' => $totalAmount,
            'extOrderId' => $order->getOrderNumber(),
            'buyer' => [
                'email' => $order->getEmail(),
                'firstName' =>$billingAddress->getName() ,
                'lastName' => $billingAddress->getSurname()
            ],
            'products' => $products 
        ];
       // dd($paymentData);

        //dd($_ENV['PAYU_CLIENT_SECRET']);
        $response = OpenPayU_Order::create($paymentData);
         return $response;
    }
}
