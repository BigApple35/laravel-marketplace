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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("product_id")->nullable();
            $table->foreign("product_id")->references("id")->on("products")->onDelete("cascade")->onUpdate("cascade");
            $table->string("nama_customer");
            $table->double("total_harga");
            $table->string("status");
            $table->unsignedBigInteger("tenant_id")->nullable();
            $table->foreign("tenant_id")->references("id")->on("tenants")->onDelete("cascade")->onUpdate("cascade");
            $table->string("nomor");
            $table->smallInteger("prioritas");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
