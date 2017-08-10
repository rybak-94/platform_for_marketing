<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "platform".
 *
 * @property integer $id
 * @property string $pb_url
 * @property string $api_url
 * @property string $api_key
 */
class Platform extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'platform';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pb_url', 'api_url', 'api_key'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pb_url' => 'Url',
            'api_url' => 'Api url',
            'api_key' => 'Api key'
        ];
    }
}
