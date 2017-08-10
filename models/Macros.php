<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "macros".
 *
 * @property integer $id
 * @property integer $offer_id
 * @property string $token_key
 * @property string $token_value
 *
 * @property Offer $offer
 */
class Macros extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'macros';
    }

    public function getOfferName(){

        $request = Yii::$app->request;
        if ($request->get('offer_id')) {
            $offer_id = $request->get('offer_id');

            $macros = Macros::find()->select(['offer_name'])
                ->leftJoin('offer', '`macros`.`offer_id` = `offer`.`id`')
                ->where(['offer_id' => $offer_id])->asArray()->one();
        }
        else{

            $macros['offer_name'] = "";
        }
    }

    public function getTokenKey()
    {
        $request = Yii::$app->request;
        if ($request->get('offer_id')) {
            $offer_id = $request->get('offer_id');

            $macs = \app\models\Macros::find()
            ->select(['token_value', 'token_key'])->from('macros')
            ->where(['offer_id'=> $offer_id])->asArray()->all();
            foreach($macs as $mac){
                print_r($mac[0]);
            }
        }
        else{

            $macs['offer_id'] = "";
        }

        return $macs;
    }



    public function macrosUpdateAll()
    {
        $request = Yii::$app->request;
        if ($request->post('token_key')){

            foreach ($request->post('token_key') as $key => $value){

                $macros = Macros::findOne($_POST['token_id'][$key]);
                $macros->token_key = $_POST['token_key'][$key];
                $macros->token_value = $_POST['token_value'][$key];
                $macros->update();
            }
        }
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['offer_id'], 'required'],
            [['offer_id'], 'integer'],
            [['token_key', 'token_value'], 'string', 'max' => 255],
            [['offer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Offer::className(), 'targetAttribute' => ['offer_id' => 'id']],
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
            'token_key' => 'Token Key',
            'token_value' => 'Token Value',
            'offer_name' => 'Offer Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOffer()
    {
        return $this->hasOne(Offer::className(), ['id' => 'offer_id']);
    }
}
