<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
        {
                Schema::create('branches', function (Blueprint $table) {
                            $table->id();
                                        $table->unsignedBigInteger('tenant_id');
                                                    $table->string('place_id')->unique();
                                                                $table->string('name');
                                                                            $table->string('address')->nullable();
                                                                                        $table->integer('user_ratings_total')->default(0);
                                                                                                    $table->float('rating')->default(0);
                                                                                                                $table->string('branch_size')->nullable();
                                                                                                                            $table->timestamps();

                                                                                                                                        $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
                                                                                                                                                });
                                                                                                                                                    }

                                                                                                                                                        public function down(): void
                                                                                                                                                            {
                                                                                                                                                                    Schema::dropIfExists('branches');
                                                                                                                                                                        }
                                                                                                                                                                        };