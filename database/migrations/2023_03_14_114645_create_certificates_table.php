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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->nullable();
            $table->string('organization_name')->nullable();
            $table->string('held_location')->nullable();
            $table->string('usg_adviser')->nullable();
            $table->string('director_student_affaire_service')->nullable();
            $table->string('date_year')->nullable();
            $table->string('school_year')->nullable();
            $table->boolean('distributed_by_osas')->nullable();
            $table->boolean('distributed_by_adviser')->nullable();
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
        Schema::dropIfExists('certificates');
    }
};
