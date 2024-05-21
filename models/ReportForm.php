<?php

namespace app\models;

use Yii;
use yii\base\Model;

/*
 * ContactForm is the model behind the contact form.
 */

class ReportForm extends Model {

    public $from_date;
    public $to_date;

    /*
     * @return array the validation rules.
     */

    public function rules() {
        return [
            [['from_date', 'to_date'], 'required'],
            ['to_date', 'checkDate']
        ];
    }

    public function checkDate($attribute, $params) {
        if ($this->from_date && $this->to_date) {
            if (strtotime($this->from_date) > strtotime($this->to_date)) {
                $this->addError($attribute, 'End date must be greater than start date ');
            }
        }
    }

}
