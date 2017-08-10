<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "status_alias".
 *
 * @property integer $id
 * @property integer $advertiser_id
 * @property string $status_advertiser
 * @property string $status_platform
 *
 * @property Advertiser $advertiser
 */
class StatusAlias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'status_alias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['advertiser_id'], 'required'],
            [['advertiser_id'], 'integer'],
            [['status_advertiser', 'status_platform'], 'string', 'max' => 255],
            [['advertiser_id'], 'exist', 'skipOnError' => true, 'targetClass' => Advertiser::className(), 'targetAttribute' => ['advertiser_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'advertiser_id' => 'Advertiser ID',
            'status_advertiser' => 'Status Advertiser',
            'status_platform' => 'Status Platform',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertiser()
    {
        return $this->hasOne(Advertiser::className(), ['id' => 'advertiser_id']);
    }
}
