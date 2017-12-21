<?php
/**
 * Created by PhpStorm.
 * User: 王凯林
 * Date: 17/12/20
 * Time: 22:55
 */
namespace backend\controllers;
use backend\models\Article;
use backend\models\ArticleCategory;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class ArticleController extends Controller{
    //文章的首页
    public function actionIndex()
    {
        $model = Article::find()->where(['>=','status','0'])->all();
        return $this->render('index',['model'=>$model]);
    }
    //文章的添加
    public function actionAdd()
    {
        //创建提交对象
        $request= \Yii::$app->request;
        //创建model对象
        $model = new Article();
        if($request->isPost){
            $model->load($request->post());
            if ($model->validate()){
                $model->create_time= time();
                $model->save();
                //输出信息并且跳转
                \Yii::$app->session->setFlash('success','添加文章成功!');
                return $this->redirect(['article/index']);
            }
        }
        //显示页面
        $model ->status=1;
        //查询category表里面的数据>>输出到下拉表选择框里面
        $article_category= ArticleCategory::find()->all();
        $category=ArrayHelper::map($article_category,'id','name');
        return $this->render('add',['model'=>$model,'categorys'=>$category]);
    }
    //文章的修改
    public function actionUpdate($id)
    {
        //创建提交对象
        $request= \Yii::$app->request;
        //创建model对象
        $model = Article::findOne(['id'=>$id]);
        if($request->isPost){
            $model->load($request->post());
            if ($model->validate()){
                $model->save();
                //输出信息并且跳转
                \Yii::$app->session->setFlash('success','修改文章成功!');
                return $this->redirect(['article/index']);
            }
        }
        //显示页面
        //查询category表里面的数据>>输出到下拉表选择框里面
        $article_category= ArticleCategory::find()->all();
        $category=ArrayHelper::map($article_category,'id','name');
        return $this->render('add',['model'=>$model,'categorys'=>$category]);
    }
    //文章的删除
    public function actionDelete($id)
    {
        //删除,该状态
        Article::updateAll(['status'=>-1],['id'=>$id]);
    }
}