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
        Schema::create('organization_processes', function (Blueprint $table) {

            $table->id();
            $table->foreignId('organization_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('campus_adviser_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('campus_adviser_approved_status')->nullable();
            $table->string('campus_adviser_endorsed_status')->nullable();
            
            $table->foreignId('campus_director_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('campus_director_approved_status')->nullable();
            $table->string('campus_director_endorsed_status')->nullable();

            $table->foreignId('osas_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('osas_approved_status')->nullable();
            $table->string('osas_endorsed_status')->nullable();
            
            $table->foreignId('vpa_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('vpa_approved_status')->nullable();
            $table->string('vpa_endorsed_status')->nullable();

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
        Schema::dropIfExists('organization_processes');
    }
};
