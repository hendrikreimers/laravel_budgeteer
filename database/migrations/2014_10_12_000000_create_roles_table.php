<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();

            // admin gruppe/rolle wird read-only
            $table->boolean('read_only')->default(0);

            // User Management
            $fieldName = 'user';
            $table->boolean($fieldName . '_view')->default(0);
            $table->boolean($fieldName . '_list')->default(0);
            $table->boolean($fieldName . '_create')->default(0);
            $table->boolean($fieldName . '_update')->default(0);
            $table->boolean($fieldName . '_delete')->default(0);

            // Gruppen
            $fieldName = 'role';
            $table->boolean($fieldName . '_view')->default(0);
            $table->boolean($fieldName . '_list')->default(0);
            $table->boolean($fieldName . '_create')->default(0);
            $table->boolean($fieldName . '_update')->default(0);
            $table->boolean($fieldName . '_delete')->default(0);

            // Kategorien (z. B. Lebensmittel,...)
            $fieldName = 'subject';
            $table->boolean($fieldName . '_view')->default(1);
            $table->boolean($fieldName . '_list')->default(1);
            $table->boolean($fieldName . '_create')->default(0);
            $table->boolean($fieldName . '_update')->default(0);
            $table->boolean($fieldName . '_delete')->default(0);
            $table->boolean($fieldName . '_globals')->default(0);

            // Konten (z. B. Bank/Kasse)
            $fieldName = 'account';
            $table->boolean($fieldName . '_view')->default(1);
            $table->boolean($fieldName . '_list')->default(1);
            $table->boolean($fieldName . '_create')->default(0);
            $table->boolean($fieldName . '_update')->default(0);
            $table->boolean($fieldName . '_delete')->default(0);
            $table->boolean($fieldName . '_globals')->default(0);

            // Buchungsbeleg
            $fieldName = 'receipt';
            $table->boolean($fieldName . '_view')->default(1);
            $table->boolean($fieldName . '_list')->default(1);
            $table->boolean($fieldName . '_create')->default(1);
            $table->boolean($fieldName . '_update')->default(1);
            $table->boolean($fieldName . '_delete')->default(1);

            // Budgets
            $fieldName = 'limit';
            $table->boolean($fieldName . '_view')->default(1);
            $table->boolean($fieldName . '_list')->default(1);
            $table->boolean($fieldName . '_create')->default(1);
            $table->boolean($fieldName . '_update')->default(1);
            $table->boolean($fieldName . '_delete')->default(1);

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
        Schema::dropIfExists('roles');
    }
}
