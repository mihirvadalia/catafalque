<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HegicUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->integer('role')->after('remember_token');
            $table->tinyInteger('super')->nullable()->after('role');
            $table->tinyInteger('active')->after('super');
            $table->integer('hrId')->after('active')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn("role");
            $table->dropColumn("super");
            $table->dropColumn("active");
            $table->dropColumn("hrId");
        });
    }
}
