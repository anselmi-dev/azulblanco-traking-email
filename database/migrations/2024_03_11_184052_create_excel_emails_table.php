<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\ExcelFile;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('excel_files', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('original_name');
            $table->enum('status', [
                "pending",
                "progress",
                "error",
                "done",
            ])->default('pending');
            $table->string('file');
            $table->json('message')->default(new Expression('(JSON_ARRAY())'));
            $table->timestamps();
        });

        Schema::create('excel_emails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('excel_file_id');
            $table->foreign('excel_file_id')->references('id')->on('excel_files')->onDelete('cascade');
            $table->string('email_arqui');
            $table->string('num_obra');
            $table->string('obra');
            $table->string('dir_obra');
            $table->string('pobla_obra');
            $table->string('provi_obra');
            $table->enum('type', [
                'private',
                'public',
            ]);
            $table->enum('status', [
                "pending",
                "progress",
                "error",
                "done",
            ])->default('pending');
            $table->json('data')->default(new Expression('(JSON_ARRAY())'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('excel_files');
        Schema::dropIfExists('excel_emails');
    }
};