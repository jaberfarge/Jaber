<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
            Schema::create('comments', function (Blueprint $table) {
                        $table->id();
                                    $table->foreignId('branch_id')->constrained()->onDelete('cascade');
                                                $table->string('author_name');
                                                            $table->text('comment_text');
                                                                        $table->string('sentiment'); // إيجابي، سلبي، محايد
                                                                                    $table->string('category');  // شكوى، ابتزاز، مطالبة، عام
                                                                                                $table->text('ai_response')->nullable();
                                                                                                            $table->boolean('sensitive_flag')->default(false);
                                                                                                                        $table->timestamps();
                                                                                                                                });
                                                                                                                                    }
                                                                                                                                        public function down(): void { Schema::dropIfExists('comments'); }
                                                                                                                                        };