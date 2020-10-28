<?php

require "../bootloader.php";

use Illuminate\Database\Capsule\Manager;

Manager::schema()::defaultStringLength(191);

Manager::schema()->create('grupo', function ($table) {
    $table->bigincrements("id");
    $table->string('nombre');
});

Manager::schema()->create('fuente', function ($table) {
    $table->string('id')
        ->primary();
    $table->string('nombre');
});

Manager::schema()->create('ciclo', function ($table) {
    $table->string('id')
        ->primary();
    $table->string('nombre');
    $table->string('siglas');
});

Manager::schema()->create('modalidad', function ($table) {
    $table->bigincrements("id");
    $table->string('nombre');
});

Manager::schema()->create('organismo', function ($table) {
    $table->string('id')
        ->primary();
    $table->string('nombre');
});

Manager::schema()->create('estado', function ($table) {
    $table->string('id')
        ->primary();
    $table->string('nombre');
});

Manager::schema()->create('distrito', function ($table) {
    $table->string('id')
        ->primary();
    $table->string('nombre');
});

Manager::schema()->create('tenencia', function ($table) {
    $table->string('id')
        ->primary();
    $table->string('nombre');
});

Manager::schema()->create('cultivo', function ($table) {
    $table->string('id')
        ->primary();
    $table->string('nombre');
    $table->unsignedBigInteger('grupo');
    $table->foreign('grupo')
        ->references('id')
        ->on('grupo')
        ->onDelete('cascade')
        ->onUpdate('cascade');
    $table->string('nombreCientifico');
});

Manager::schema()->create('produccionAgricola', function ($table) {
    $table->bigincrements("id");
    $table->string('anio');

    $table->string('distrito');
    $table->foreign('distrito')
        ->references('id')
        ->on('distrito')
        ->onDelete('cascade')
        ->onUpdate('cascade');

    $table->string('estado');
    $table->foreign('estado')
        ->references('id')
        ->on('estado')
        ->onDelete('cascade')
        ->onUpdate('cascade');

    $table->string('organismoCuenca');
    $table->foreign('organismoCuenca')
        ->references('id')
        ->on('organismo')
        ->onDelete('cascade')
        ->onUpdate('cascade');

    $table->string('ciclo');
    $table->foreign('ciclo')
        ->references('id')
        ->on('ciclo')
        ->onDelete('cascade')
        ->onUpdate('cascade');

    $table->string('tenencia');
    $table->foreign('tenencia')
        ->references('id')
        ->on('tenencia')
        ->onDelete('cascade')
        ->onUpdate('cascade');

    $table->unsignedBigInteger('modalidad');
    $table->foreign('modalidad')
        ->references('id')
        ->on('modalidad')
        ->onDelete('cascade')
        ->onUpdate('cascade');

    $table->string('cultivo');
    $table->foreign('cultivo')
        ->references('id')
        ->on('cultivo')
        ->onDelete('cascade')
        ->onUpdate('cascade');

    $table->double('sembrada');
    $table->double('cosechada');
    $table->integer('produccion');
    $table->double('valor');
});

Manager::schema()->create('volumenDistribuido', function ($table) {
    $table->bigincrements("id");

    $table->string('anio');

    $table->string('distrito');
    $table->foreign('distrito')
        ->references('id')
        ->on('distrito')
        ->onDelete('cascade')
        ->onUpdate('cascade');

    $table->string('fuente');
    $table->foreign('fuente')
        ->references('id')
        ->on('fuente')
        ->onDelete('cascade')
        ->onUpdate('cascade');

    $table->string('tenencia');
    $table->foreign('tenencia')
        ->references('id')
        ->on('tenencia')
        ->onDelete('cascade')
        ->onUpdate('cascade');

    $table->string('estado');
    $table->foreign('estado')
        ->references('id')
        ->on('estado')
        ->onDelete('cascade')
        ->onUpdate('cascade');

    $table->string('organismoCuenca');
    $table->foreign('organismoCuenca')
        ->references('id')
        ->on('organismo')
        ->onDelete('cascade')
        ->onUpdate('cascade');

    $table->double('regada1');
    $table->double('distribuido1');
    $table->integer('usuario1');

    $table->double('regada2');
    $table->double('distribuido2');
    $table->integer('usuario2');

    $table->double('regada3');
    $table->double('distribuido3');
    $table->integer('usuario3');
});
?>
