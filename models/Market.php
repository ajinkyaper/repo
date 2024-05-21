<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "market".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 */
class Market extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'market';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['name', 'status'], 'required'],
            [['name'], 'string', 'max' => 100, 'min' => 2],
            [['name'], 'filter', 'filter' => 'trim'],
            ['name', 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Market Name',
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
}
