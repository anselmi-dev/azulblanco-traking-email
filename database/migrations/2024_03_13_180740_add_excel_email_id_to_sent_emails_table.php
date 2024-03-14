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
        Schema::table('sent_emails', function (Blueprint $table) {
            $table->unsignedBigInteger('excel_email_id')->nullable()->after('id');
            $table->foreign('excel_email_id')->references('id')->on('excel_emails')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sent_emails', function (Blueprint $table) {
            $table->dropForeign(['excel_email_id']);
        });
    }
};
