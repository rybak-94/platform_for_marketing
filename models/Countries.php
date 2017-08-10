<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "countries".
 *
 * @property integer $id
 * @property string $country_code
 * @property string $country_name
 */
class Countries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'countries';
    }

        public function getCountry(){

            if (isset($_POST['country_code'])) {
                foreach ($_POST['country_code'] as $key => $value) {
                    $countries = Countries::findOne($_POST['country_id'][$key]);
                    $value1 = strtolower($_POST['country_code'][$key]);
                    $countries->country_code = $value1;
                    $countries->update();
                }
            }

        //print_r($country);

    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_code'], 'string', 'max' => 2],
            [['country_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country_code' => 'Country Code',
            'country_name' => 'Country Name',
        ];
    }
}
