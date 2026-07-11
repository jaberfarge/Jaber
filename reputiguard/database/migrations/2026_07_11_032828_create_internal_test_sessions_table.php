<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
        {
                Schema::create('internal_test_sessions', function (Blueprint $table) {
                            $table->id();
                                        $table->string('session_type'); // subscription_testing, review_testing, reply_testing
                                                    $table->boolean('active')->default(true);
                                                                $table->json('parameters')->nullable();
                                                                            $table->boolean('reset_after_test')->default(true);
                                                                                        $table->timestamps();
                                                                                                });
                                                                                                    }

                                                                                                        public function down(): void
                                                                                                            {
                                                                                                                    Schema::dropIfExists('internal_test_sessions');
                                                                                                                        }
                                                                                                                        };