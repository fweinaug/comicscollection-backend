<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "publishers".
 *
 * @property int $id
 * @property string $name
 * @property int $image_id
 * @property string $description
 * @property string $website
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Images $image
 */
class Publishers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'publishers';
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
            [['name'], 'required'],
            [['image_id'], 'integer'],
            [['description', 'website'], 'string'],
            [['name'], 'string', 'max' => 100],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Images::className(), 'targetAttribute' => ['image_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'image_id' => 'Image ID',
            'description' => 'Description',
            'website' => 'Website',
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
            'imageUrl' => function ($model) {
                return $model->getImageUrl();
            },
            'description',
            'website',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Images::className(), ['id' => 'image_id']);
    }

    public function getImageUrl()
    {
        if (!$this->image_id)
            return null;

        return Images::getUrl($this->image_id);
    }
}
