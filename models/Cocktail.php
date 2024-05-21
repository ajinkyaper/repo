<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cocktail".
 *
 * @property int $id
 * @property string $name
 * @property int $marque_id
 * @property string $ingredients
 * @property string $instructions
 * @property int $is_active
 * @property string $created_at
 * @property string $updated_at
 * @property string $image
 * @property string $url
 *
 * @property CocktailOccasion[] $cocktailOccasion
 * @property Occasions[] $occasions
 */
class Cocktail extends \yii\db\ActiveRecord
{

    public $Occasions;
    public $uploaded_image;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cocktail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['marque_id', 'ingredients', 'instructions', 'name', 'url'], 'required'],
            ['url', 'url'],
            ['image', 'string'],
            [['Occasions', 'ingredients', 'uploaded_image', 'is_active'], 'safe'],


        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'marque_id' => 'Marques',
            'name' => 'Cocktail Name',
            'ingredients' => 'Ingredients',
            'instructions' => 'Instructions',
            'url' => 'CTA'
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
     * Gets query for [[CocktailOccasion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCocktailOccasion() // this will return related occasions
    {
        return $this->hasMany(CocktailOccasion::class, ['cocktail_id' => 'id']);
    }

    public function getOccasions() //this will return all occasions
    {
        return $this->hasMany(CocktailOccasion::class, ['cocktail_id' => 'id']);
    }

    public function getMarques()
    {
        return $this->hasOne(Marques::class, ['id' => 'marque_id']);
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
