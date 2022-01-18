<?php

namespace app\controllers;

use app\models\Tasks;
use Faker\Factory;
use PHPUnit\Util\Log\JSON;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;
use \yii\rest\Controller;

class TasksController extends ActiveController
{
    public $modelClass = '\app\models\Tasks';


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['authenticator']);
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
        ];
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'except' => ['options'],
        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@', '?']
                ]
            ]
        ];
        return $behaviors;
    }

    public function actionTaskadd()
    {
        return "Task add";
    }

    public function actionGettasks()
    {
        $id = \Yii::$app->getUser()->getId();
        $result = Tasks::find()->where(['ownerId' => 1])->limit(100)->all(``);
        $tasks = array();
        foreach ($result as $task) {
            if (!isset($tasks[$task['state']])){
                $tasks[$task['state']]=array();
            }else{
                $tasks[$task['state']][$task['taskId']] =array(
                    'deadline' => $task['deadline'],
                    'assigne' => $task['assignee'],
                    'title' => $task['title'],
                    'content' => $task['content'],
                    'type' => $task['type'],
                    'priority' => $task['priority'],
                    'grade' => $task['grade'],
                    'state' => $task['state']
                );
            }
        }
        return [
            'status' => "success",
            'data' => $tasks
        ];
    }

    public function actionGenerate()
    {
        $faker = Factory::create();
        $stateArray = array('Completed', 'To verify', 'Plan', 'In progress');
        $prArray = array("Default", "Critic", "Serious", "Emergency", "Minor");
        for ($i = 0; $i < 50000000; $i++) {
            $task = new Tasks();
            $key = \Yii::$app->security->generateRandomString(16);
            $task->taskId = 'T' . $key;
            $task->ownerId = 1;
            $task->title = $faker->word();
            $task->content = $faker->text(200);
            $task->assignee = $faker->text(55);
            $stateKey = array_rand($stateArray, 1);
            $prKey = array_rand($prArray, 1);
            $task->state = $stateArray[$stateKey];
            $task->priority = $prArray[$prKey];
            $task->save();
        }
    }
    public function actionCreate_project(){
        return "Sa;,";
    }

}
