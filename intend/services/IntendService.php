<?php

namespace micro\services;

use backend\models\product\Products;
use frontend\models\Lead;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Yii;
use yii\base\Exception;

class InTendService
{
    public function getProductPrice($product_id)
    {
        $product = Products::findOne($product_id);
        $summa = $product->getPriceBySum()*100;
        $client = Yii::createObject(Client::class);
        $data = [
            "api_key" => "Apikey",
            "price" => $summa
        ];
        $request = $client->get('https://pay.intend.uz/api/v1/front/calculate', [
            'json' => $data,
            'headers'  => [
                'content-type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);

        $data= json_decode($request->getBody()->getContents())->data->items[0];

        $cookies = Yii::$app->response->cookies;

        $cookies->add(new \yii\web\Cookie([
            'name' => 'product_price',
            'value' => $data->price/100,
            'expire' => time() + 86400 * 365,
        ]));

        return $data;
    }

    public function isActive($phone_number)
    {
        $phone = mb_substr(str_replace('+', '',  $phone_number), 3,11);
        $array = [];

        $client = Yii::createObject(Client::class);


        try{
            $data = [
                'username' => $phone
            ];
            $response1 = $client->post('https://pay.intend.uz/api/v1/external/member/check', [
                'json' => $data,
                'headers'  => [
                    'content-type' => 'application/json',
                    'Accept' => 'application/json',
                    'api-key' => 'Apikey'
                ],
            ]);

            if($response1->getStatusCode() == 500)
            {
                throw new ClientException('Username not found');
            }

            $data = json_decode($response1->getBody()->getContents())->data;

            if($data->status == -1)
            {
                $array['status'] = $data->status;
                $array['limit'] = null;

                return $array;
            }
            if($data->status == 1)
            {
                $array['status'] = $data->status;
                $auth_client = Yii::createObject(Client::class);
                $data = [
                    "username" => $data->username,
                    "token" => hash("sha512", $data->username."$"."oQ)'OU)5YCMR=~fqCoDmX!XU4u't,y")
                ];
                $response2 = $auth_client->post('https://pay.intend.uz/api/v1/external/member/auth', [
                    'json' => $data,
                    'headers'  => [
                        'content-type' => 'application/json',
                        'Accept' => 'application/json',
                        'api-key' => 'Apikey'
                    ],
                ]);

                $body_data = json_decode($response2->getBody()->getContents())->data;

                $cookies = Yii::$app->response->cookies;

                $cookies->add(new \yii\web\Cookie([
                    'name' => 'token',
                    'value' => $body_data->token,
                    'expire' => time() + 86400 * 365,
                ]));

                $limit_client = Yii::createObject(Client::class);
                $response3 = $limit_client->get('https://pay.intend.uz/api/v1/external/member/limits',[
                    'headers'  => [
                        'content-type' => 'application/json',
                        'Accept' => 'application/json',
                        'api-key' => 'Apikey',
                        'Authorization' => 'Bearer '.$body_data->token,
                    ],
                ]);
                $newData = json_decode($response3->getBody()->getContents());
                if($newData->success){
                    $array['limit'] =$newData->data->limit;
                }else{
                    $array['limit'] = 1;
                }


                return $array;
            }
            return true;
        }

        catch (\Exception $e)
        {
            throw new Exception('Some problem in response');
        }

    }

    public function createLead($data)
    {

        $product = Products::findOne(['id' => $data['product_id']]);
        if(!$product)
        {
            throw new Exception('Product not found');
        }
        $lead = Yii::createObject(Lead::class);
        $lead->product_id = $product->id;
        $lead->quantity = 1;
        $lead->name = 'user';
        $lead->phone = $data['phone_number'];
        $lead->status = 1;
        $lead->price = Yii::$app->getRequest()->getCookies()->getValue('product_price');
        $lead->payment = 2;
        $lead->month_price = Yii::$app->getRequest()->getCookies()->getValue('product_price')/12;
        if($lead->save(false))
        {
            $order_client = Yii::createObject(Client::class);
            $data = [
                "duration" => 12,
                "redirect_url" => "http://bitech.uz/products",
                "order_id" => $lead->id,
                "products" => [
                    [
                        "id" => $product->id,
                        "price" => $product->getPriceBySum()*100,
                        "quantity" => $lead->quantity,
                        "name" => $product->name,
                        "sku" =>  "test",
                        "weight" => null,
                        "url" => "http://bitech.uz/products/".$product->slug,
                    ]

                ]
            ];

            $response = $order_client->post('https://pay.intend.uz/api/v1/external/order/create', [
                'json' => $data,
                'headers'  => [
                    'content-type' => 'application/json',
                    'Accept' => 'application/json',
                    'api-key' => 'Apikey',
                    'Authorization' => 'Bearer '.Yii::$app->getRequest()->getCookies()->getValue('token'),
                ],
            ]);

            $data = json_decode($response->getBody()->getContents());

            if($data->success == true)
            {
                $cookies = Yii::$app->response->cookies;

                $cookies->add(new \yii\web\Cookie([
                    'name' => 'ref_id',
                    'value' => $data->data->ref_id,
                    'expire' => time() + 86400 * 365,
                ]));

                $lead_model = Lead::findOne(['id' => $lead->id]);
                $lead_model->ref_id = $data->data->ref_id;
                if(!$lead_model->update())
                {
                    return 'Not update lead model';
                }
                return $data->success;
            }
            else{
                return 'Data not success';
            }
        }

        else{
            return 'Buyurtma bazaga saqlanmadi';
        }
    }

    public function checkSms($sms)
    {
        $info = [];
        $lead = Lead::findOne(['ref_id' => Yii::$app->getRequest()->getCookies()->getValue('ref_id')]);
        if($lead->ref_id && $sms)
        {
            $sms_client = Yii::createObject(Client::class);
            $sms_data = [
                "code" => $sms,
                "ref_id" => $lead->ref_id
            ];
            $response_sms = $sms_client->post('https://pay.intend.uz/api/v1/external/cheque/confirm', [
                'json' => $sms_data,
                'headers'  => [
                    'content-type' => 'application/json',
                    'Accept' => 'application/json',
                    'api-key' => 'Apikey',
                    'Authorization' => 'Bearer '.Yii::$app->getRequest()->getCookies()->getValue('token'),
                ],
            ]);

            $data = json_decode($response_sms->getBody()->getContents());



            if($data->success)
            {
                $lead->active = 1;
                $lead->intend_order_id = $data->data->order_id;
                if(!$lead->save(false))
                {
                    return 'Not update lead order id';
                }
                $info['info'] = 'Xaridingiz uchun rahmat';
                $info['status'] = $data->success;
                return $info;
            }
            else{
                $info['info'] = 'Xato sms kod kiritdingiz';
                $info['status'] = $data->success;
                return $info;
            }
        }
        else{
            return 'Sms or ref_id not found';
        }
    }

}

