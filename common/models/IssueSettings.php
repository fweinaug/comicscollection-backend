<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "issue_settings".
 *
 * @property int $id
 * @property int $comic_id
 * @property int $issue_id
 * @property int $profile_id
 * @property int $read
 * @property int $rating
 *
 * @property Issues $issue
 * @property Profiles $profile
 */
class IssueSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'issue_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comic_id', 'issue_id', 'profile_id', 'read', 'rating'], 'required'],
            [['comic_id', 'issue_id', 'profile_id'], 'integer'],
            [['read', 'rating'], 'string', 'max' => 1],
            [['comic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comics::className(), 'targetAttribute' => ['comic_id' => 'id']],
            [['issue_id'], 'exist', 'skipOnError' => true, 'targetClass' => Issues::className(), 'targetAttribute' => ['issue_id' => 'id']],
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
            'issue_id' => 'Issue ID',
            'profile_id' => 'Profile ID',
            'read' => 'Read',
            'rating' => 'Rating',
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id',
            'read',
            'rating',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIssue()
    {
        return $this->hasOne(Issues::className(), ['id' => 'issue_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profiles::className(), ['id' => 'profile_id']);
    }
}
