<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "moments".
 */
class MomentV3 extends \yii\db\ActiveRecord
{
    public $uploaded_image;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'moments_v3';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['name', 'description', 'image'], 'string'],
            [['status', 'updated_by'], 'integer'],
            [['created_at', 'updated_at', 'image', 'uploaded_image'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'image' => 'Image',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function beforeSave($insert)
    {

        $this->updated_at = date("Y-m-d H:i:s");
        $this->updated_by = Yii::$app->user->identity->id;
        if ($insert) {
            $this->created_at = date("Y-m-d H:i:s");
        }

        return parent::beforeSave($insert);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    public static function getAllMoments()
    {
        return static::find()
            ->with('user')
            ->orderBy("name ASC")
            ->all();
    }
}
