<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('login');
            $table->string('phone');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('father_name')->nullable();
            $table->string('avatar')->default('default_avatar.jpg');
            $table->integer('age')->nullable();
            $table->text('about')->nullable();
            $table->foreignId('gender_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('occupation_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('role_id')->default(1)->constrained()->cascadeOnDelete();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('tg_name')->nullable();
            $table->string('tg_id')->nullable();
            $table->string('vk_url')->nullable();
            $table->boolean('active')->default(true);
            $table->string('curator_job')->nullable();
            $table->string('curator_about')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
