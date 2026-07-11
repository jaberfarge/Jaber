<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
        {
                Schema::create('unknown_activities', function (Blueprint $table) {
                            $table->id();
                                        $table->string('place_id')->unique();
                                                    $table->string('name');
                                                                $table->json('google_types')->nullable();
                                                                            $table->integer('appearance_count')->default(1);
                                                                                        $table->boolean('admin_notified')->default(false);
                                                                                                    $table->boolean('manual_mapping_allowed')->default(true);
                                                                                                                $table->timestamps();
                                                                                                                        });
                                                                                                                            }

                                                                                                                                public function down(): void
                                                                                                                                    {
                                                                                                                                            Schema::dropIfExists('unknown_activities');
                                                                                                                                                }
                                                                                                                                                };