<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $category_name
 * @property int $status 0-active, 2-inactive
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_name', 'status'], 'required'],
            [['status', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['category_name'], 'string', 'max' => 100],
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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_name' => 'Category Name',
            'status' => 'Status',
        ];
    }

    // public function getCreatedBy()
    // {
    //     return $this->hasOne(User::class, ['id' => 'created_by']);
    // }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }
}
