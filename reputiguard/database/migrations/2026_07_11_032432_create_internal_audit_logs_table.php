<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
        {
                Schema::create('internal_audit_logs', function (Blueprint $table) {
                            $table->id();
                                        $table->string('action');
                                                    $table->string('user');
                                                                $table->string('ip')->nullable();
                                                                            $table->string('device')->nullable();
                                                                                        $table->string('browser')->nullable();
                                                                                                    $table->json('details')->nullable();
                                                                                                                $table->timestamp('created_at')->useCurrent();
                                                                                                                        });
                                                                                                                            }

                                                                                                                                public function down(): void
                                                                                                                                    {
                                                                                                                                            // immutable → لا يتم حذف الجدول
                                                                                                                                                }
                                                                                                                                                };