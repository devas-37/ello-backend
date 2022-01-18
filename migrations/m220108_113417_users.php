<?php

use yii\db\Migration;


class m220108_113417_users extends Migration
{


    public function up()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'email' => $this->string(80)->unique(),
            'password' => $this->string(100),
            'userName' => $this->string(50),
            'avatar' => $this->text()->defaultValue(null),
            'accessToken' => $this->string(100),
            'googleId'=>$this->text(),
        ]);
    }

    public function down()
    {
        $this->dropTable('users');
    }

}
