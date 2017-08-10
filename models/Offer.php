<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "offers".
 *
 * @property integer $id
 * @property string $offer_name
 * @property integer $advertiser_id
 *
 * @property Advertiser $advertiser
 */
class Offer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'offer';
    }

    public function getItemTokenKey()
    {
        $raw_data=[];

        foreach ($this->macros as $item){
            $raw_data[] = $item->token_key;
        }
        return implode('<hr>', $raw_data);
    }

    public function getItemTokenValue()
    {
        $raw_data=[];

        foreach ($this->macros as $item){
            $raw_data[] = $item->token_value;
        }
        return implode(
            $raw_data, '<hr>');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['offer_name', 'advertiser_id'], 'required'],
            [['advertiser_id'], 'integer'],
            [['offer_name'], 'string', 'max' => 255],
            [['advertiser_id'], 'exist', 'skipOnError' => true, 'targetClass'
            => Advertiser::className(), 'targetAttribute' => ['advertiser_id' => 'id']],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'offer_name' => 'Offer Name',
            'advertiser_id' => 'advertiser id',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertiser()
    {
        return $this->hasOne(Advertiser::className(), ['id' => 'advertiser_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMacros()
    {
        return $this->hasMany(Macros::className(), ['offer_id' => 'id']);
    }

}
