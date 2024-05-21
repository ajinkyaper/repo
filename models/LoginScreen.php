<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "moments".
 *
 * @property int $mom_id
 * @property string $mom_name
 * @property string $mom_des
 * @property string $mom_img
 * @property int $des_show
 *
 * @property BrandView[] $brandViews
 * @property CatView[] $catViews
 * @property MomentView[] $momentViews
 * @property OccView[] $occViews
 * @property Occasions[] $occasions
 * @property ProTrack[] $proTracks
 */
class LoginScreen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'login_screens';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image'], 'required'],
            [['image'], 'string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Image',
            'created_at' => 'Created At'
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at  = date("Y-m-d H:i:s");
            }
            return true;
        } else return false;
    }
}
