<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
        {
                Schema::create('reviews', function (Blueprint $table) {
                            $table->id();
                                        $table->unsignedBigInteger('tenant_id');
                                                    $table->unsignedBigInteger('branch_id');
                                                                $table->string('review_id')->unique();
                                                                            $table->integer('rating');
                                                                                        $table->text('raw_text');
                                                                                                    $table->text('cleaned_text')->nullable();
                                                                                                                $table->string('language')->nullable();
                                                                                                                            $table->string('sentiment')->nullable();
                                                                                                                                        $table->string('risk_level')->nullable();
                                                                                                                                                    $table->boolean('is_sensitive')->default(false);
                                                                                                                                                                $table->timestamp('review_time')->nullable();
                                                                                                                                                                            $table->timestamps();

                                                                                                                                                                                        $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
                                                                                                                                                                                                    $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
                                                                                                                                                                                                            });
                                                                                                                                                                                                                }

                                                                                                                                                                                                                    public function down(): void
                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                Schema::dropIfExists('reviews');
                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                    };