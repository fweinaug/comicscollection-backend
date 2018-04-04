<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "images".
 *
 * @property int $id
 * @property resource $image_data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Comics[] $comics
 * @property Issues[] $issues
 */
class Images extends \yii\db\ActiveRecord
{
    public $image_file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images';
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
            [['image_data'], 'required'],
            [['image_data'], 'string'],
            [['image_file'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_data' => 'Image Data',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComics()
    {
        return $this->hasMany(Comics::className(), ['image_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIssues()
    {
        return $this->hasMany(Issues::className(), ['image_id' => 'id']);
    }

    public function getImageUrl()
    {
        return self::getUrl($this->id);
    }

    public static function getUrl($id)
    {
        return Url::to(['image/raw', 'id' => $id], true);
    }
}
