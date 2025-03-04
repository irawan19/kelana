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
        Schema::create('penawaran_barangs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('penawarans_id')->unsigned()->index()->nullable();
            $table->foreign('penawarans_id')->references('id')->on('penawarans')->onUpdate('set null')->onDelete('set null');
            $table->bigInteger('barangs_id')->unsigned()->index()->nullable();
            $table->foreign('barangs_id')->references('id')->on('barangs')->onUpdate('set null')->onDelete('set null');
            $table->double('harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penawaran_barangs');
    }
};
