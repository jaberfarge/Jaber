<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
        {
                Schema::create('replies', function (Blueprint $table) {
                            $table->id();
                                        $table->unsignedBigInteger('tenant_id');
                                                    $table->unsignedBigInteger('branch_id');
                                                                $table->unsignedBigInteger('review_id');
                                                                            $table->text('generated_text')->nullable();
                                                                                        $table->text('published_text')->nullable();
                                                                                                    $table->string('ai_model')->nullable();
                                                                                                                $table->string('prompt_version')->nullable();
                                                                                                                            $table->integer('quality_score')->nullable();
                                                                                                                                        $table->boolean('is_published')->default(false);
                                                                                                                                                    $table->timestamps();

                                                                                                                                                                $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
                                                                                                                                                                            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
                                                                                                                                                                                        $table->foreign('review_id')->references('id')->on('reviews')->onDelete('cascade');
                                                                                                                                                                                                });
                                                                                                                                                                                                    }

                                                                                                                                                                                                        public function down(): void
                                                                                                                                                                                                            {
                                                                                                                                                                                                                    Schema::dropIfExists('replies');
                                                                                                                                                                                                                        }
                                                                                                                                                                                                                        };