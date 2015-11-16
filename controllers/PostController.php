<?php

namespace app\controllers;

use app\models\Post;
use yii\data\Pagination;
use Yii;
use yii\web\Controller;
use app\models\PostForm;

class PostController extends Controller
{
    public $defaultAction = 'index';

    public function actionIndex()
    {
        $model = new PostForm();
        $model->scenario = 'default';
        if (!Yii::$app->user->isGuest)
        {
            if ($model->load(Yii::$app->request->post()) && $model->validate())
            {
                $model->send();
                $this->goHome();
            }
        }
        else if ($model->load(Yii::$app->request->post()))
        {
            Yii::$app->session->setFlash('error', 'Необходимо зерегестрироваться');
            Yii::error('Необходимо зерегестрироваться');
        }
        $query = Post::find();
        $posts = $query->orderBy(['date' => SORT_DESC ])
            ->all();

        return $this->render('index', [
            'model' => $model,
            'posts' => $posts,
        ]);
    }

}
