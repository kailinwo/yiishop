<?php
/**
 * Created by PhpStorm.
 * User: 王凯林
 * Date: 17/12/20
 * Time: 14:19
 */
namespace backend\models;
use yii\db\ActiveRecord;

class Brands extends ActiveRecord{
    public $img;
    public function rules()
    {
        return [
            [['name','intro','img','status'],'required'],
            [['sort'],'number'],
        ];
    }
}