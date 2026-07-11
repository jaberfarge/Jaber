<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
        {
                Schema::create('internal_preview_businesses', function (Blueprint $table) {
                            $table->id();
                                        $table->unsignedBigInteger('tenant_id');
                                                    $table->boolean('owner_visible_only')->default(true);
                                                                $table->boolean('generate_without_publish')->default(true);
                                                                            $table->boolean('store_results_only')->default(true);
                                                                                        $table->boolean('compare_ai_versions')->default(true);
                                                                                                    $table->timestamps();

                                                                                                                $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
                                                                                                                        });
                                                                                                                            }

                                                                                                                                public function down(): void
                                                                                                                                    {
                                                                                                                                            Schema::dropIfExists('internal_preview_businesses');
                                                                                                                                                }
                                                                                                                                                };