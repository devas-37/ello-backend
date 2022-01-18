<?php

use yii\db\Migration;

/**
 * Class m220111_071253_projects
 */
class m220111_071253_projects extends Migration
{
    public function up()
    {
    $this->createTable('projects',[
        'id'=>$this->primaryKey(),
        'userId'=>$this->string(12)->unique(),
        'name'=>$this->string(100),
        'description'=>$this->text(),
        'developers'=>$this->text(),
        'createdAt'=>$this->integer(),
        'owner'=>$this->string(100),
        'taskId'=>$this->string(12),
        'tasksId'=>$this->string(12),
        'kanbans'=>$this->text()
    ]);
    }

    public function down()
    {
        $this->dropTable('projects');
    }
}
