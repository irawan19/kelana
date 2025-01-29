<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kategoris_id')->unsigned()->index()->nullable();
            $table->foreign('kategoris_id')->references('id')->on('kategoris')->onUpdate('set null')->onDelete('set null');
            $table->bigInteger('tipes_id')->unsigned()->index()->nullable();
            $table->foreign('tipes_id')->references('id')->on('tipes')->onUpdate('set null')->onDelete('set null');
            $table->longtext('nama');
            $table->double('harga');
            $table->double('stok');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
