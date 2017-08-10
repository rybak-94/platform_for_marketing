<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "advertiser".
 *
 * @property integer $id
 * @property string $advertiser_name
 * @property string $pb_method
 * @property string $pb_url
 * @property string $pbr_success
 * @property string $check_response
 */
class Advertiser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advertiser';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['advertiser_name', 'pb_method', 'pb_url', 'pbr_success', 'check_response'], 'required'],
            [['advertiser_name', 'pb_method', 'pb_url', 'pbr_success', 'check_response'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'advertiser_name' => 'Advertiser Name',
            'pb_method' => 'Pb Method',
            'pb_url' => 'Pb Url',
            'pbr_success' => 'Pbr Success',
            'check_response' => 'Check Response'
        ];
    }
}
