<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('invoice_penjualan_stock_movements')) {
            return;
        }

        Schema::table('invoice_penjualan_stock_movements', function (Blueprint $table): void {
            if (! Schema::hasColumn('invoice_penjualan_stock_movements', 'gudang_id')) {
                $table->unsignedBigInteger('gudang_id')->nullable()->after('stock_id');
            }

            if (! Schema::hasColumn('invoice_penjualan_stock_movements', 'nama_barang')) {
                $table->string('nama_barang', 100)->nullable()->after('gudang_id');
            }

            if (! Schema::hasColumn('invoice_penjualan_stock_movements', 'satuan_terkecil')) {
                $table->string('satuan_terkecil', 50)->nullable()->after('nama_barang');
            }

            if (! Schema::hasColumn('invoice_penjualan_stock_movements', 'harga_beli')) {
                $table->decimal('harga_beli', 15, 2)->default(0)->after('satuan_terkecil');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('invoice_penjualan_stock_movements')) {
            return;
        }

        Schema::table('invoice_penjualan_stock_movements', function (Blueprint $table): void {
            $columns = [];

            foreach (['harga_beli', 'satuan_terkecil', 'nama_barang', 'gudang_id'] as $column) {
                if (Schema::hasColumn('invoice_penjualan_stock_movements', $column)) {
                    $columns[] = $column;
                }
            }

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
