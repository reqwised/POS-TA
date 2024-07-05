<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePenjualanAndMemberAndPenjualanDetailTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update table penjualan
        Schema::table('penjualan', function (Blueprint $table) {
            $table->integer('diskon')->change();
            $table->string('kode_invoice')->nullable(); // Adding kode_invoice attribute
        });

        // Update table member
        Schema::table('member', function (Blueprint $table) {
            $table->integer('hutang')->nullable(); // Adding hutang attribute
        });

        // Update table penjualan_detail
        Schema::table('penjualan_detail', function (Blueprint $table) {
            $table->integer('diskon')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert changes to table penjualan
        Schema::table('penjualan', function (Blueprint $table) {
            $table->tinyInteger('diskon')->change();
            $table->dropColumn('kode_invoice'); // Removing kode_invoice attribute
        });

        // Revert changes to table member
        Schema::table('member', function (Blueprint $table) {
            $table->dropColumn('hutang'); // Removing hutang attribute
        });

        // Revert changes to table penjualan_detail
        Schema::table('penjualan_detail', function (Blueprint $table) {
            $table->tinyInteger('diskon')->change();
        });
    }
}
