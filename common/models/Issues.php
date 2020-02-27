<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "issues".
 *
 * @property int $id
 * @property int $comic_id
 * @property int $number
 * @property string $title
 * @property int $image_id
 * @property string $summary
 * @property string $release_date
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property IssueSettings[] $settings
 * @property Comics $comic
 * @property Images $image
 */
class Issues extends \yii\db\ActiveRecord
{
    public $read;
    public $rating;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'issues';
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
            [['comic_id', 'number', 'title'], 'required'],
            [['comic_id', 'number', 'image_id'], 'integer'],
            [['title', 'summary'], 'string'],
            [['release_date'], 'safe'],
            [['title', 'summary'], 'default', 'value' => null],
            ['release_date', 'datetime', 'format' => 'php:Y-m-d'],
            [['read', 'rating'], 'safe'],
            [['comic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comics::className(), 'targetAttribute' => ['comic_id' => 'id']],
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
            'comic_id' => 'Comic ID',
            'number' => 'Number',
            'title' => 'Title',
            'image_id' => 'Image ID',
            'summary' => 'Summary',
            'release_date' => 'Release Date',
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
            'number',
            'title',
            'image' => function ($model) {
                return Images::getUrls($model->image_id);
            },
            'summary',
            'release_date',
            'read' => function ($model) {
                return (bool)$model->read;
            },
            'rating' => function ($model) {
                return (int)$model->rating;
            },
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
    public function getSettings()
    {
        return $this->hasMany(IssueSettings::className(), ['issue_id' => 'id']);
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
    public function getImage()
    {
        return $this->hasOne(Images::className(), ['id' => 'image_id']);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert)
        {
            $comic = $this->comic;
            $comic->issues_count++;

            if ($comic->image_id === null)
                $comic->image_id = $this->image_id;

            $comic->save();
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        $comic = $this->comic;
        $comic->issues_count--;

        $comic->save();

        parent::afterDelete();
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

            $comic = $this->comic;
            if ($comic->image_id === null || $this->number <= 1) {
                $comic->image_id = $image->id;
                $comic->save();
            }

            if ($currentImage !== null) {
                $currentImage->delete();
            }

            return true;
        }

        return false;
    }

    public static function getIssuesOfComicWithSettings($comicId, $profileId)
    {
        return Issues::find()
            ->select([ 'issue_settings.*', 'issues.*' ])
            ->joinWith('settings')
            ->where([ 'issues.comic_id' => $comicId, 'issue_settings.profile_id' => $profileId ])
            ->all();
    }

    public static function getIssueWithSettings($issueId, $profileId)
    {
        return Issues::find()
            ->select([ 'issue_settings.*', 'issues.*' ])
            ->joinWith('settings')
            ->where([ 'issues.id' => $issueId, 'issue_settings.profile_id' => $profileId ])
            ->one();
    }

    public static function getNextIssueNumber($comicId) {
        $number = Issues::find()
            ->select('number')
            ->where(['issues.comic_id' => $comicId])
            ->max('number');

        return intval($number) + 1;
    }
}
