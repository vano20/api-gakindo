<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 100)->nullable(false);
            $table->string('contact_person', 100)->nullable(false);
            $table->string('email', 200)->nullable(false);
            $table->string('phone_number', 20)->nullable(false);
            $table->string('position', 100)->nullable(false);
            $table->string('company_address', 200)->nullable(false);
            $table->string('npwp', 16)->nullable(false);
            $table->string('qualification', 100)->nullable(false);
            $table->tinyInteger('status')->nullable(false)->comment('1: verified, 0: not verified, 2: rejected');
            $table->string('period', 4)->nullable(false);
            $table->unsignedBigInteger('province_id')->nullable(false);
            $table->string('membership_id', 200)->nullable();
            $table->timestamps();

            $table->foreign("province_id")->on("provinces")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registrations');
    }
}
