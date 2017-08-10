<?php
namespace app\commands;

use app\models\Conversion;
use yii\base\Model;
use Yii;
use yii\console\Controller;

class CronController extends Controller
{
    public function actionIndex()
    {
        echo "cron service runnning ";

        $conversions = new Conversion();
        //$conversions->getConversionQuery();
        //$conversions->changeDateConversion();
        //$conversions->checkStatusConversion();

        return [
            'cron' => 'yii2mod\cron\actions\CronLogAction',
            // Also you can override some action properties in following way:
            'cron' => [
                'class' => 'yii2mod\cron\actions\CronLogAction',
                'searchClass' => [
                    'class' => 'yii2mod\cron\models\search\CronScheduleSearch',
                    'pageSize' => 10
                ],
                'view' => 'custom name of the view, which should be rendered.'
            ]
        ];
    }
}

