<?php

namespace app\controllers;

class ProjectController extends \yii\rest\Controller
{
    public function behaviors()
    {

        $behaviors = parent::behaviors();
        $behaviors['authenticator']=[
            'class'=>HttpBearerAuth::class,
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::class,
            'actions' => [
                'new_project' => ['POST']
            ]
        ];
        return $behaviors;
    }
}
