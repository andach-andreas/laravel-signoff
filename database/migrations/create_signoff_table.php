<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('signoffs', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('signoffable_id');
            $table->string('signoffable_type');
            $table->uuid('user_id');
            $table->timestamp('first_signoff_timestamp')->nullable();
            $table->binary('first_signoff_image')->nullable();
            $table->boolean('is_second_signoff_required')->nullable();
            $table->string('second_user_id')->nullable();
            $table->timestamp('second_signoff_timestamp')->nullable();
            $table->binary('second_signoff_image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
