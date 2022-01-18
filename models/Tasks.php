<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%todoTasks}}".
 *
 * @property int $id
 * @property string|null $taskId
 * @property string|null $ownerId
 * @property string|null $title
 * @property string|null $content
 * @property string|null $createdAt
 * @property string|null $deadline
 * @property string|null $priority
 * @property string|null $assignee
 * @property string|null $state
 * @property string|null $grade
 * @property string|null $type
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%todoTasks}}';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content', 'priority', 'assignee', 'state', 'type'], 'string'],
            [['ownerId'], 'number'],
            [['createdAt', 'deadline'], 'safe'],
            [['taskId'], 'string', 'max' =>20],
            [['title'], 'string', 'max' => 255],
            [['taskId'], 'unique'],
        ];
    }

    
}
