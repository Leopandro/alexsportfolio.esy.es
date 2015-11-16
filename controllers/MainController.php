<?php
/**
 * Created by PhpStorm.
 * User: Алексей
 * Date: 06.11.2015
 * Time: 18:01
 */
namespace app\controllers;

use Yii;
use app\models\RegForm;
use app\models\LoginForm;
use yii\web\Controller;
use app\models\User;

class MainController extends Controller
{


    public function actionReg()
    {
        $model = new RegForm;
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            if ($user = $model->reg())
            {
                if ($user->status === User::STATUS_ACTIVE)
                {
                    if (Yii::$app->getUser()->login($user))
                        return $this->goHome();
                }
            }
            else
            {
                Yii::$app->session->setFlash('error', 'Возникла ошибка при регистрации');
                Yii::error('Ошибка регистрации');
                return $this->refresh();
            }
        }
        return $this->render(
            'reg',
            [
                'model' => $model
            ]
        );
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }

        $model = new LoginForm;
        if ($model->load(Yii::$app->request->post()) && $model->login())
        {
            return $this->goBack();
        }
        return $this->render(
            'login',
            [
                'model' => $model
            ]
        );
    }
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}

?>