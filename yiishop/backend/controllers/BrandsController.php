<?php

namespace backend\controllers;

use backend\models\Brand;
use backend\models\Brands;
use yii\web\UploadedFile;

class BrandsController extends \yii\web\Controller
{
    //品牌的首页
    public function actionIndex()
    {
        $model =Brands::find()->where(['>=','status',0])->all() ;
        return $this->render('index',['model'=>$model]);
    }
    //品牌的添加
    public function actionAdd()
    {
        //创建提交对象
        $request = \Yii::$app->request;
        //创建model对象
        $model= new Brands();
        if($request->isPost){
            //加载表单的数据
            $model->load($request->post());
            //创建图片的上传对象
            $model->img= UploadedFile::getInstance($model,'img');
            //验证数据
            if($model->validate()){
                //图片上传的路径,
                $dirname = "Uploads/".\Yii::$app->controller->id.'/'.date('Ymd')."/";
                if(!is_dir($dirname)){
                    //如果目录不存在,就创建目录
                    mkdir($dirname,0777,true);
                }
                //处理文件名
                $filename = uniqid().'.'.$model->img->extension;
                $files='/'.$dirname.$filename;
                //移动文件到指定的目录里面去
                if($model->img->saveAs(\Yii::getAlias('@webroot').$files)){
                    $model->logo = $files;
                }
//                var_dump($model->logo);die;
                $model->save();
                //提示信息
                \Yii::$app->session->setFlash('success','添加品牌成功!');
                //跳转值品牌表首页
                return $this->redirect(['brands/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    //品牌的修改
    public function actionUpdate($id)
    {
        //创建提交对象
        $request = \Yii::$app->request;
        //根据id显示查询数据表
        $model = Brands::findOne(['id'=>$id]);
        if($request->isPost){
            //加载表单数据
            $model->load($request->post());
            //创建图片的上传对象
            $model->img= UploadedFile::getInstance($model,'img');
            if($model->validate()){
                //图片上传的路径,
                $dirname = "Uploads/".\Yii::$app->controller->id.'/'.date('Ymd')."/";
                if(!is_dir($dirname)){
                    //如果目录不存在,就创建目录
                    mkdir($dirname,0777,true);
                }
                //处理文件名
                $filename = uniqid().'.'.$model->img->extension;
                $files='/'.$dirname.$filename;
                //移动文件到指定的目录里面去
                if($model->img->saveAs(\Yii::getAlias('@webroot').$files)){
                    $model->logo = $files;
                }
                $model->save();
                //提示信息
                \Yii::$app->session->setFlash('success','修改品牌成功!');
                //跳转值品牌表首页
                return $this->redirect(['brands/index']);
            }
        }
        //显示页面
        return $this->render('add',['model'=>$model]);
    }
    //品牌的删除
    public function actionDelete($id)
    {
        //这是一个假的删除>>更改该条数据的状态值
//        if(\Yii::$app->db->createCommand()->update('brands',['status'=>-1],['id'=>$id])){
//            //提示信息
//            \Yii::$app->session->setFlash('danger','删除该条数据成功!');
//            //跳转回首页
////            return $this->redirect(['brand/index']);
//        }else{
//            //提示信息
//            \Yii::$app->session->setFlash('danger','删除该数据失败!');
//        }
        Brands::updateAll(['status'=>-1],['id'=>$id]);

    }
}
