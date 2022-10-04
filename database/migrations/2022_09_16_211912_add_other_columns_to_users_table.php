<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Enum;
use PhpParser\Node\Stmt\Enum_;

class AddOtherColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('employee_id')->unique()->nullable()->after('id');
            $table->foreignId('department_id')->after('employee_id');
            $table->string('phone')->unique()->after('email');
            $table->string('nrc_number')->nullable()->after('phone');
            $table->date('birthday')->nullable()->after('nrc_number');
            $table->enum('gender', ['male','female'])->nullable()->after('birthday');
            $table->text('address')->nullable()->after('gender');
            $table->date('date_of_join')->nullable()->after('address');
            $table->boolean('is_present')->default(true)->after('date_of_join');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['employee_id','department_id','phone','nrc_number','birthday','gender','address','date_of_join','is_present']);
        });
    }
}
