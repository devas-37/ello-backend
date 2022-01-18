<?php

use yii\db\Migration;


class m220109_090528_todoTasks extends Migration
{



    public function up()
    {
        $this->createTable('todoTasks',[
            'id'=>$this->primaryKey(),
            'taskId'=>$this->string(18)->unique(),
            'ownerId'=>$this->integer(),
            'title'=>$this->string(),
            'content'=>$this->text(),
            'createdAt'=>$this->integer(),
            'deadline'=>$this->integer(),
            'priority'=>$this->text(),
            'assignee'=>$this->text(),
            'state'=>$this->text(),
            'grade'=>$this->string(50),
            'type'=>$this->text(),
            'creator'=>$this->text()
        ]);
    }

    public function down()
    {
        $this->dropTable('todoTasks');
    }

}
