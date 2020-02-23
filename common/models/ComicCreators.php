<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comic_creators".
 *
 * @property int $id
 * @property int $comic_id
 * @property int $person_id
 * @property string $contribution
 *
 * @property Comics $comic
 * @property People $person
 */
class ComicCreators extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comic_creators';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comic_id', 'person_id'], 'required'],
            [['comic_id', 'person_id'], 'integer'],
            [['contribution'], 'default', 'value' => null],
            [['contribution'], 'string', 'max' => 150],
            [['comic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comics::className(), 'targetAttribute' => ['comic_id' => 'id']],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => People::className(), 'targetAttribute' => ['person_id' => 'id']],
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
            'person_id' => 'Person ID',
            'contribution' => 'Contribution',
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
    public function getPerson()
    {
        return $this->hasOne(People::className(), ['id' => 'person_id']);
    }
}
