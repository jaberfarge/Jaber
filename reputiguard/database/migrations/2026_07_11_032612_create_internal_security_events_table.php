<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
        {
                Schema::create('internal_security_events', function (Blueprint $table) {
                            $table->id();
                                        $table->string('event_type'); // failed_login, unauthorized_access, rate_limit_triggered
                                                    $table->string('user')->nullable();
                                                                $table->string('ip')->nullable();
                                                                            $table->string('device')->nullable();
                                                                                        $table->string('browser')->nullable();
                                                                                                    $table->json('details')->nullable();
                                                                                                                $table->timestamp('created_at')->useCurrent();
                                                                                                                        });
                                                                                                                            }

                                                                                                                                public function down(): void
                                                                                                                                    {
                                                                                                                                            Schema::dropIfExists('internal_security_events');
                                                                                                                                                }
                                                                                                                                                };