<?php

namespace app\controllers;

use PHPUnit\Util\Log\JSON;
use yii\base\Security;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\rest\Controller;
use app\models\Users;
use yii\web\User;

class UsersController extends Controller
{

    public $authType;
    public $modelClass = 'app\models\Users';
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::class,
            'actions' => [
                'create' => ['POST'],
                'login' => ['POST']
            ]
        ];
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class];
        return $behaviors;
    }
    public function actionIndex()
    {
        $model = new Users();
        return [\Yii::$app->getUser()->identity, $model->getAuthKey()];
    }
    public function actionCreate()
    {
        if (\Yii::$app->request->isPost) {
            $model = new Users();
            $post = \Yii::$app->request->post();
            $authType = isset($post['OAuthToken']) ? 'GOOGLE' : 'DEFAULT';
            if ($authType == 'DEFAULT') {
                $model->userName = $post['username'];
                $model->email = $post['email'];
                $model->password = \Yii::$app->getSecurity()->generatePasswordHash($post['password']);
                if ($model->validate()) {
                    $token = \Yii::$app->getSecurity()->generateRandomString(64);
                    $model->accessToken = $token;
                    if ($model->save()) {
                        return ['status' => 'success', 'user'=>[
                            'accessToken'=>$token,
                            'avatar'=>null,
                            'email'=>$model->email,
                            'userName'=>$model->userName
                        ]];
                    } else {
                        \Yii::$app->response->statusCode=423;
                        return ['status' =>[
                            'error'=> $model->errors
                        ]];
                    }
                } else {
                    \Yii::$app->response->statusCode=423;
                    return ['status' =>[
                        'error'=> $model->errors
                    ]];
                }
            } else {
                {

                }
            }
        }
    }
    public function actionLogin()
    {
        if (\Yii::$app->request->isPost) {
            $model = new Users();
            $post = \Yii::$app->request->post();
            $authType = isset($post['OAuthToken']) ? 'GOOGLE' : 'DEFAULT';
            if ($authType == 'DEFAULT') {
                $user = $model->getUserByEmail($post['email']);
                if ($user != null && \Yii::$app->getSecurity()->validatePassword($post['password'], $user['password'])) {
                    unset($user['password'], $user['id'],$user['googleId']);
                    return [
                        'status' => 'success',
                        'user' => $user
                    ];
                }
                \Yii::$app->response->statusCode=423;
                return [
                    'status' => [
                        'error' => 'Incorrect email or password'
                    ]
                ];
            } else {
                $email=$post['email'];
                $googleId=$post['googleId'];
                $user=$model->getUserByEmail($email);
                if ($user!=null  && $googleId==$user['googleId']){
                    unset($user['password'], $user['id'],$user['googleId']);
                    return [
                        'status' => 'success',
                        'user' => $user
                    ];
                }else{
                    \Yii::$app->response->statusCode=423;
                   return['status' => [
                        'error' => 'User not found!'
                    ]];
                }
            }
        }
    }
}