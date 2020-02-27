<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "people".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property int $created_at
 * @property int $updated_at
 * @property string name
 */
class People extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'people';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name'], 'required'],
            [['first_name', 'last_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id',
            'name',
            'first_name',
            'last_name',
            'created_at' => function ($model) {
                return date(DATE_ATOM, $model->created_at);
            },
            'updated_at' => function ($model) {
                return date(DATE_ATOM, $model->updated_at);
            },
        ];
    }

    public function getName()
    {
        return $this->first_name.' '.$this->last_name;
    }
}
