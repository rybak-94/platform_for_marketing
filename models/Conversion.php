<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\db\Query;
use yii\debug\models\search\Log;

/**
 * This is the model class for table "conversion".
 *
 * @property integer $id
 * @property integer $offer_id
 * @property string $click_id
 * @property string $lead_country
 * @property string $lead_landing
 * @property string $user_ip
 * @property string $user_country
 * @property string $date_lead
 * @property string $status
 * @property string $response_s2s
 * @property string $lead_sub1
 * @property string $lead_sub2
 * @property string $lead_sub3
 * @property string $check
 * @property string $cvr_hash
 *
 * @property Offer $offer
 */
class Conversion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'conversion';
    }

    //Собираем данные в массив и записываем в базу
    public function getElementForConversion(){

        Yii::$app->controller->enableCsrfValidation = false;
        $server_uri = Yii::$app->getRequest()->url;
        $request = Yii::$app->request;


        if ( isset($_POST["lead"]) && $_POST["lead"] == "2atkF5CbchVP9gbn") {
            $data = unserialize(base64_decode($_POST["data"]));

            $conversions = new Conversion();
            foreach ($data as $key=>$value){
                $conversions->$key=$value;
            }
            if(isset($data["user_ip"]))
                $conversions->user_country = geoip_country_code_by_name($data["user_ip"]);

            try{
                $conversions->save();
            }
            catch (Exception $e){
                $errorData = array("method"=> "getElementForConversion",
                    "URI" => $server_uri,'GET' => $request->get(), "POST" => $request->post());
                $error = base64_encode(serialize($errorData));
                $getMessage = $e->getMessage();
                $logs = new Logs();
                $logs->message = $getMessage;
                $logs->data =  $error;
                $logs->save();
            }
        }
    }

    public function takeData()
    {
        Yii::$app->controller->enableCsrfValidation = false;
        $request = Yii::$app->request;

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            print_r("dqsdqs");
        }
        else {
            echo "<pre>";
            print_r($_GET);
            echo "</pre>";
        }
    }

    // Собираем массив элементов для отправки в партнёрку
    public function getConversionQuery()
    {
        $conversions = Conversion::find()->select(['conversion.*', "GROUP_CONCAT(
            CONCAT_WS('=', macros.token_key, macros.token_value) SEPARATOR '&') 
            AS 'pb_macros', pb_method, pb_url, pbr_success, check_response "])->from('conversion')
            ->leftJoin('offer', '`conversion`.`offer_id` = `offer`.`id`')
            ->leftJoin('macros', '`macros`.`offer_id` = `offer`.`id`')
            ->leftJoin('advertiser', '`offer`.`advertiser_id` = `advertiser`.`id`')
            ->where(['conversion.check' => 0])->groupBy('conversion.id')
            ->asArray()->all();

        return $conversions;
    }

    //Преобразуем массив в норм вид
    public function changeDateConversion()
    {
        $new_conversions = array();

        $conversions=$this->getConversionQuery();

        foreach ($conversions as $conversion)
        {
                $arr = explode("&", $conversion['pb_macros']);
                $new_arr = array();
                foreach ($arr as $value){
                    $item = explode("=", $value);
                    if (count($item) < 2)
                        $new_arr[$item[0]] = "";
                    else
                        $new_arr[$item[0]] = $item[1];
                }
                $conversion['pb_macros'] = $new_arr;

            //Преобразование макросов вида [[...]] к значениям ключей
            foreach ($conversion['pb_macros'] as $key => $value)
            {
                $record_key = str_replace(['[[', ']]'], '', $value);
                if (array_key_exists($record_key, $conversion))
                    $conversion['pb_macros'][$key] = $conversion[$record_key];
            }

            array_push($new_conversions, $conversion);
        }
        return $new_conversions;
    }


    // Отправляем данные в партнёрку
    public function sendData($url, $method, $value=false, $header=false)
    {
        $server_output="";

        $sendConversionMacros = curl_init($url);

        switch($method)
        {
            case 'POST':
                curl_setopt($sendConversionMacros, CURLOPT_POST, 1);
                curl_setopt($sendConversionMacros, CURLOPT_POSTFIELDS, http_build_query($value));
                break;
            case 'GET':
                break;
            case 'PUT':
                curl_setopt($sendConversionMacros, CURLOPT_CUSTOMREQUEST, 'PUT');
                break;
            case 'DELETE':
                curl_setopt($sendConversionMacros, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }
        curl_setopt($sendConversionMacros, CURLOPT_RETURNTRANSFER, true);
        if($header){
            curl_setopt($sendConversionMacros, CURLOPT_HTTPHEADER,
                array($header));
        }
        $server_output = curl_exec($sendConversionMacros);
        echo "<pre>";
        print_r($server_output);
        echo "</pre>";

        $httpCode = curl_getinfo($sendConversionMacros, CURLINFO_HTTP_CODE);

        if ($httpCode == 404){
            $server_output = 404;
        }
        curl_close ($sendConversionMacros);

        return $server_output;
    }

    public function checkStatusConversion()
    {
        $new_conversions=$this->changeDateConversion();

            foreach ($new_conversions as $conversion) {
                $server_output = $this->sendData($conversion['pb_url'], $conversion['pb_method'],
                    $conversion['pb_macros']);
                $convId = $conversion['id'];
                if ($server_output == 404) {
                    $this->updateStatusConversion("error" . "(" . $server_output . ")", $convId);
                    continue;
                }
                    if ($conversion['check_response'] !== "1") {
                        $this->updateStatusConversion("0", $convId);
                    }
                    else {
                        if ($server_output == $conversion['pbr_success']) {
                            $this->updateStatusConversion("0", $convId);

                        }
                        else {
                            $this->updateStatusConversion("error" . "(" . $server_output . ")", $convId);

                        }
                    }

                echo "<pre>";
                print_r($conversion);
                echo "</pre>";
            }
    }

    public function updateStatusConversion($value, $conversion)
    {
            $statusConversion = Conversion::findOne($conversion);
            $statusConversion->status = $value;
            $statusConversion->check = 1;
            $statusConversion->update();
        return $statusConversion;
    }


    public function getQueryAd($cvr_hash, $status_advertiser)
    {
        if(strlen($cvr_hash) == 0){
            $cvr_hash = "none";
        }
        //$cvr_hash = "xxx";
        $conversions = Conversion::find()->select(['conversion.*', 'status_alias.status_advertiser',
            'status_alias.status_platform'])
            ->from('conversion')->leftJoin('offer', '`conversion`.`offer_id` = `offer`.`id`')
            ->leftJoin('status_alias', '`offer`.`advertiser_id` = `status_alias`.`advertiser_id`')
            ->where(['cvr_hash' => $cvr_hash, 'status_advertiser' => $status_advertiser])->asArray()->one();


        echo "<pre>";
        print_r($conversions);
        echo "</pre>";

        return $conversions;
    }

    public function checkStatusAd()
    {
        $request = Yii::$app->request;
        $server_uri = Yii::$app->getRequest()->url;

        $cvr_hash = $request->get('cvr_hash', "none");
        $status_advertiser = $request->get('status', "0");
        $conversions=$this->getQueryAd($cvr_hash, $status_advertiser);

            if (isset($conversions))
            {
                $conversions['status'] = $this->changeStatusAd($conversions['status_platform'], $conversions);
            }
            else
            {
                $logs = $this->changeLogAd($server_uri, $cvr_hash);
                false;
            }
    }

    public function changeStatusAd($value, $conversions)
    {
        $request = Yii::$app->request;
        $server_uri = Yii::$app->getRequest()->url;

        $statusConversion = Conversion::findOne($conversions['id']);
        $statusConversion->status = $value;
        $statusConversion->update();

        $platform = Platform::find()->asArray()->one();

            $record_click = str_replace('[[click_id]]', $statusConversion['click_id'], $platform);
            $record = str_replace('[[status]]', $statusConversion['status'], $record_click);

        print_r($record['pb_url']);

            $server_output = $this->sendData($record['pb_url'], 'GET', false, false);
            print_r($server_output);

        $logs =json_decode($server_output);
        $status = $logs->status;

        if ($status == 1){
            $log = "status=" . $status;
            $statusConversion->response_s2s = $log;
            $statusConversion->update();
        }
        else{
            $message = $logs->message;
            $log = "status=" . $status . " message=" . $message;
            $statusConversion->response_s2s = $log;
            $statusConversion->update();
        }


        echo "<pre>";
        print_r($record);
        echo "</pre>";

        return $statusConversion;
    }

    public function changeLogAd($log, $cvr_hash)
    {
            $logStatus = new Logs();
            $logStatus->log = $log;
            $logStatus->cvr_hash = $cvr_hash;
            $logStatus->save();
    }

    public function getRequestAd()
    {
        $request = Yii::$app->request;
        if ($request->isGet && ($request->get('method') == 'pb'))
        {
            $this->checkStatusAd();
        }
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_lead'], 'safe'],
            [[ 'check'], 'integer'],
            [['click_id', 'lead_country', 'lead_landing', 'user_ip', 'user_country', 'status',
                'response_s2s', 'lead_sub1', 'lead_sub2', 'lead_sub3', 'cvr_hash'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'offer_id' => 'Offer ID',
            'click_id' => 'Click ID',
            //'partner_id' => 'Partner ID',
            //'lead_id' => 'Lead ID',
            'lead_country' => 'Lead Country',
            'lead_landing' => 'Lead Landing',
            'user_ip' => 'User Ip',
            'user_country' => 'User Country',
            'date_lead' => 'Date Lead',
            'status' => 'Status',
            'response_s2s' => 'Response S2s',
            'lead_sub1' => 'Lead Phone',
            'lead_sub2' => 'Lead Name',
            'lead_sub3' => 'Lead Name',
            'check' => 'Check',
            'cvr_hash' => 'Cvr hash'
        ];
    }
}
