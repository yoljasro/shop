<?php
/**
 * Created by PhpStorm.
 * User: xushnud
 * Date: 25.11.2020
 * Time: 12:17
 */

namespace micro\controllers;


use backend\models\product\Products;
use micro\services\InTendService;
use GuzzleHttp\Client;
use yii\web\Controller;
use Yii;
use yii\web\Cookie;


class IntendController extends \yii\rest\Controller
{

    public $inTendService;

//    public function __construct($id, $module, InTendService $inTendService, $config = [])
//    {
//        parent::__construct($id, $module, $config);
//        $this->inTendService = $inTendService;
//    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionAsd()
    {
        return [
            'status' => 'ok',
            'data' => 'asd'
        ];
    }
    
    public function actionGetProductPrice($product_id)
    {
        return $this->inTendService->getProductPrice($product_id);
    }

    public function actionPhoneIsActive()
    {
        if(Yii::$app->request->isAjax)
        {
            return $this->inTendService->isActive(Yii::$app->request->post('phone'));
        }
        return 'Is not ajax';
    }


    public function actionCreateLead()
    {
        if(Yii::$app->request->isAjax)
        {
            return $this->inTendService->createLead(Yii::$app->request->post());
        }
        return 'Some error';
    }

    public function actionSmsConfirm()
    {
        if(Yii::$app->request->isAjax)
        {
            return $this->inTendService->checkSms(Yii::$app->request->post('sms'));
        }
        return 'Some error';
    }

}
