<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%projects}}".
 *
 * @property int $id
 * @property string|null $userId
 * @property string|null $name
 * @property string|null $description
 * @property string|null $developers
 * @property int|null $createdAt
 * @property string|null $owner
 * @property string|null $taskId
 * @property string|null $tasksId
 */
class Projects extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%projects}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'developers'], 'string'],
            [['createdAt'], 'integer'],
            [['userId', 'taskId', 'tasksId'], 'string', 'max' => 12],
            [['name', 'owner'], 'string', 'max' => 100],
            [['userId'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'name' => 'Name',
            'description' => 'Description',
            'developers' => 'Developers',
            'createdAt' => 'Created At',
            'owner' => 'Owner',
            'taskId' => 'Task ID',
            'tasksId' => 'Tasks ID',
        ];
    }
}
