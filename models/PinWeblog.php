<?php

namespace app\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "pin_weblogs".
 *
 * @property int $id
 * @property int $pin
 * @property string $ip
 * @property string $created_at
 */
class PinWeblog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pin_weblogs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pin', 'ip', 'created_at'], 'required'],
            [['pin'], 'integer'],
            [['created_at'], 'safe'],
            [['ip'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pin' => 'Pin',
            'ip' => 'Ip',
            'created_at' => 'Created At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PinWeblogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PinWeblogQuery(get_called_class());
    }
    public function beforeValidate()
    {
        $this->ip = Yii::$app->cms->getIp();
        $this->created_at = date('Y-m-d H:i:s');
        if (parent::beforeValidate()) {
            return true;
        }
        return false;
    }
    public function check($pin)
    {
        $model = new PinWeblog;
        $model->pin = $pin;
        $valid = $model->validate();

        if (!$valid) {
            return false;
        }
        $ip = Yii::$app->cms->getIp();
        $created_at = date('Y-m-d H:i:s');
        $find = PinWeblog::find(['pin' => $pin, 'ip' => $ip])->orderBy('created_at DESC')->one();
        if ($find) {
            $diff = strtotime($created_at) - strtotime($find->created_at);

            if ($diff <= 5) {
                return false;
            }
        }

        $pinWeblog = new PinWeblog();
        $pinWeblog->pin = $pin;
        $save = $pinWeblog->save();
        if (!$save) {
            return false;
        }
        if ($find) {
            $find->delete();
        }
        return true;
    }
}
