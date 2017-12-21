<?php
/**
 * Created by PhpStorm.
 * User: 王凯林
 * Date: 17/12/20
 * Time: 18:52
 */
namespace backend\models;
use yii\db\ActiveRecord;

class ArticleCategory extends ActiveRecord{


    public function rules()
    {
        return [
            [['name','intro','sort','status'],'required'],
            ['sort','number'],
        ];
    }
}