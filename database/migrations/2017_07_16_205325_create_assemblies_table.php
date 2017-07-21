<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Create or remove an ‘assemblies’ table from the database.
 */
class CreateAssembliesTable extends Migration
{
    /**
     * Create the table.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assemblies', function (Blueprint $table) {

            // Primary key.
            // Rather than using an auto-incrementing identifier, this primary
            // key uses a single letter, each assembly having a different one.
            $table->char('id', 1)->primary();

            // Name of the assembly, in several languages.
            $table->string('name_en');
            $table->string('name_fr');
            $table->string('name_nl');
        });
    }

    /**
     * Destroys the table.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assemblies');
    }
}
