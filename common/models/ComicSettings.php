<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comic_settings".
 *
 * @property int $id
 * @property int $comic_id
 * @property int $profile_id
 * @property int $favorite
 *
 * @property Comics $comic
 * @property Profiles $profile
 */
class ComicSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comic_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comic_id', 'profile_id', 'favorite'], 'required'],
            [['comic_id', 'profile_id'], 'integer'],
            [['favorite'], 'string', 'max' => 1],
            [['comic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comics::className(), 'targetAttribute' => ['comic_id' => 'id']],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profiles::className(), 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comic_id' => 'Comic ID',
            'profile_id' => 'Profile ID',
            'favorite' => 'Favorite',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComic()
    {
        return $this->hasOne(Comics::className(), ['id' => 'comic_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profiles::className(), ['id' => 'profile_id']);
    }
}
