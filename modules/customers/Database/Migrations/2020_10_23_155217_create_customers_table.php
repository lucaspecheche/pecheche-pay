<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 16)->unique()->nullable();
            $table->morphs('customerable');
            $table->timestamps();

            $table->unique(['customerable_type', 'customerable_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
