<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
        {
                Schema::create('internal_feature_flags', function (Blueprint $table) {
                            $table->id();
                                        $table->string('flag_name')->unique();
                                                    $table->string('state')->default('enabled'); // enabled, disabled, beta, pilot, deprecated
                                                                $table->json('allowed_customers')->nullable();
                                                                            $table->json('allowed_activities')->nullable();
                                                                                        $table->json('allowed_subscriptions')->nullable();
                                                                                                    $table->boolean('owner_only')->default(true);
                                                                                                                $table->timestamps();
                                                                                                                        });
                                                                                                                            }

                                                                                                                                public function down(): void
                                                                                                                                    {
                                                                                                                                            Schema::dropIfExists('internal_feature_flags');
                                                                                                                                                }
                                                                                                                                                };