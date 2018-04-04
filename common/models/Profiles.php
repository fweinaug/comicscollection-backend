<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "profiles".
 *
 * @property int $id
 * @property string $name
 * @property string $accent_color
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property ComicSettings[] $comicSettings
 * @property IssueSettings[] $issueSettings
 */
class Profiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profiles';
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
            [['name'], 'string', 'max' => 25],
            [['accent_color'], 'string', 'max' => 7],
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
            'accent_color' => 'Accent Color',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComicSettings()
    {
        return $this->hasMany(ComicSettings::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIssueSettings()
    {
        return $this->hasMany(IssueSettings::className(), ['profile_id' => 'id']);
    }
}
