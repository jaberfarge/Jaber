<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
        {
                Schema::create('tenants', function (Blueprint $table) {
                            $table->id();
                                        $table->string('place_id')->unique();
                                                    $table->string('name');
                                                                $table->json('google_types')->nullable();
                                                                            $table->string('activity_type')->nullable();
                                                                                        $table->string('activity_status')->default('active');
                                                                                                    $table->integer('user_ratings_total')->default(0);
                                                                                                                $table->float('rating')->default(0);
                                                                                                                            $table->boolean('is_chain')->default(false);
                                                                                                                                        $table->string('chain_type')->nullable();
                                                                                                                                                    $table->string('pricing_version')->default('v1');
                                                                                                                                                                $table->timestamps();
                                                                                                                                                                        });
                                                                                                                                                                            }

                                                                                                                                                                                public function down(): void
                                                                                                                                                                                    {
                                                                                                                                                                                            Schema::dropIfExists('tenants');
                                                                                                                                                                                                }
                                                                                                                                                                                                };