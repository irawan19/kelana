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
        Schema::create('supplier_barangs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('suppliers_id')->unsigned()->index()->nullable();
            $table->foreign('suppliers_id')->references('id')->on('suppliers')->onUpdate('set null')->onDelete('set null');
            $table->bigInteger('barangs_id')->unsigned()->index()->nullable();
            $table->foreign('barangs_id')->references('id')->on('barangs')->onUpdate('set null')->onDelete('set null');
            $table->double('harga_beli');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_barangs');
    }
};
