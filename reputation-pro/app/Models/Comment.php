<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

        protected $fillable = [
                'branch_id',
                        'author_name',
                                'comment_text',
                                        'sentiment',
                                                'category',
                                                        'ai_response',
                                                                'sensitive_flag'
                                                                    ];

                                                                        /**
                                                                             * علاقة التعليق بالفرع (التعليق ينتمي لفرع واحد)
                                                                                  */
                                                                                      public function branch()
                                                                                          {
                                                                                                  return $this->belongsTo(Branch::class);
                                                                                                      }
                                                                                                      }