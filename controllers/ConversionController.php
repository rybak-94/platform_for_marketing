<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\Conversion;
use yii\console\controllers;

class ConversionController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action)
    {
            $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
            $conversions = new Conversion();
            $conversions->getElementForConversion();
            //$conversions->getConversionQuery();
            //$conversions->changeDateConversion();
            $conversions->checkStatusConversion();
    }


    public function actionTake()
    {
        $conversion = new Conversion();
        $conversion->takeData();
        //$conversion->checkStatusAd();
        //$conversion->getRequestAd();
    }


    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }
}