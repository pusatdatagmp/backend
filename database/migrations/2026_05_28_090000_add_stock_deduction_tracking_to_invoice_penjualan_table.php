<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('invoice_penjualan') && ! Schema::hasColumn('invoice_penjualan', 'stock_deducted_at')) {
            Schema::table('invoice_penjualan', function (Blueprint $table): void {
                $table->timestamp('stock_deducted_at')->nullable()->after('status_pembayaran');
            });
        }

        if (! Schema::hasTable('invoice_penjualan_stock_movements')) {
            Schema::create('invoice_penjualan_stock_movements', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('invoice_penjualan_id')->constrained('invoice_penjualan')->cascadeOnDelete();
                $table->string('stock_table', 50);
                $table->unsignedBigInteger('stock_id');
                $table->unsignedBigInteger('gudang_id')->nullable();
                $table->string('nama_barang', 100);
                $table->string('satuan_terkecil', 50)->nullable();
                $table->decimal('harga_beli', 15, 2)->default(0);
                $table->decimal('qty', 15, 2);
                $table->timestamps();

                $table->index(['invoice_penjualan_id', 'stock_table']);
                $table->index(['stock_table', 'stock_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_penjualan_stock_movements');

        if (Schema::hasTable('invoice_penjualan') && Schema::hasColumn('invoice_penjualan', 'stock_deducted_at')) {
            Schema::table('invoice_penjualan', function (Blueprint $table): void {
                $table->dropColumn('stock_deducted_at');
            });
        }
    }
};
