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
 * @property string $short_name
 * @property int $image_id
 * @property string $description
 * @property string $website
 * @property integer $founded
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
            [['name', 'short_name'], 'required'],
            [['image_id', 'founded'], 'integer'],
            [['description', 'website'], 'string'],
            [['description', 'website'], 'default', 'value' => null],
            [['name', 'short_name'], 'string', 'max' => 100],
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
            'short_name' => 'Short Name',
            'image_id' => 'Image ID',
            'description' => 'Description',
            'website' => 'Website',
            'founded' => 'Founded',
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
            'short_name',
            'image' => function ($model) {
                return $model->image_id !== null ? Images::getUrls($model->image_id) : null;
            },
            'founded',
            'description',
            'website',
            'created_at' => function ($model) {
                return date(DATE_ATOM, $model->created_at);
            },
            'updated_at' => function ($model) {
                return date(DATE_ATOM, $model->updated_at);
            },
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

    public function updateImage(Images $image)
    {
        if ($image->save()) {
            $currentImage = $this->image;

            $this->image_id = $image->id;
            $this->save();

            if ($currentImage !== null) {
                $currentImage->delete();
            }

            return true;
        }

        return false;
    }
}
