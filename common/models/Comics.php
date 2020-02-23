<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "comics".
 *
 * @property int $id
 * @property string $name
 * @property int $image_id
 * @property int $publisher_id
 * @property int $issues_total
 * @property int $issues_count
 * @property int $concluded
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Images $image
 * @property Publishers $publisher
 * @property ComicSettings[] $settings
 * @property ComicCreators[] $creators
 * @property Issues[] $issues
 */
class Comics extends \yii\db\ActiveRecord
{
    public $profile_id;
    public $issues_read;
    public $favorite;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comics';
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
            [['name', 'publisher_id', 'concluded'], 'required'],
            [['image_id', 'publisher_id', 'issues_total', 'issues_count'], 'integer'],
            [['profile_id', 'issues_read', 'concluded', 'favorite'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['issues_count'], 'default', 'value' => 0],
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
            'publisher_id' => 'Publisher ID',
            'issues_total' => 'Issues Total',
            'issues_count' => 'Issues Count',
            'issues_read' => 'Issues Read',
            'concluded' => 'Concluded',
            'favorite' => 'Favorite',
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
            'issuesCount' => function ($model) {
                return (int)$model->issues_count;
            },
            'issuesRead' => function ($model) {
                return (int)$model->issues_read;
            },
            'imageUrl' => function ($model) {
                return $model->getImageUrl();
            },
            'concluded' => function ($model) {
                return (bool)$model->concluded;
            },
            'publisher',
            'favorite' => function ($model) {
                return (bool)$model->favorite;
            },
            'issues' => function ($model) {
                return Issues::getIssuesOfComicWithSettings($model->id, $model->profile_id);
            }
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Images::className(), ['id' => 'image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublisher()
    {
        return $this->hasOne(Publishers::className(), ['id' => 'publisher_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSettings()
    {
        return $this->hasMany(ComicSettings::className(), ['comic_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreators()
    {
        return $this->hasMany(ComicCreators::className(), ['comic_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIssues()
    {
        return $this->hasMany(Issues::className(), ['comic_id' => 'id']);
    }

    public function getImageUrl()
    {
        if (!$this->image_id)
            return null;

        return Images::getUrl($this->image_id);
    }

    public static function getComicsWithSettings($profileId)
    {
        $subquery = IssueSettings::find()
            ->select('comic_id, count(*) as issues_read')
            ->where([ 'profile_id' => $profileId, 'read' => true ])
            ->groupBy('comic_id');
        
        return Comics::find()
            ->select([ 'comic_settings.*', 'comics.*', 's.*'])
            ->leftJoin(['s' => $subquery], 's.comic_id = comics.id')
            ->innerJoin('comic_settings', 'comic_settings.comic_id = comics.id')
            ->where([ 'comic_settings.profile_id' => $profileId ])
            ->with(['publisher'])
            ->all();
    }

    public static function getComicWithSettings($profileId, $comicId)
    {
        $subquery = IssueSettings::find()
            ->select('comic_id, count(*) as issues_read')
            ->where([ 'profile_id' => $profileId, 'read' => true ])
            ->groupBy('comic_id');
        
        return Comics::find()
            ->select([ 'comic_settings.*', 'comics.*', 's.*'])
            ->leftJoin(['s' => $subquery], 's.comic_id = comics.id')
            ->innerJoin('comic_settings', 'comic_settings.comic_id = comics.id')
            ->where([ 'comics.id' => $comicId, 'comic_settings.profile_id' => $profileId ])
            ->with(['publisher'])
            ->one();
    }
}
