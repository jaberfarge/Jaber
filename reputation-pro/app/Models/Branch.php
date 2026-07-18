<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

        // الحقول المسموح بتعبئتها
            protected $fillable = [
                    'name',
                            'place_id',
                                    'business_type',
                                            'auto_tier',
                                                    'knowledge_base'
                                                        ];

                                                            /**
                                                                 * علاقة الفرع بالتعليقات (الفرع له الكثير من التعليقات)
                                                                      */
                                                                          public function comments()
                                                                              {
                                                                                      return $this->hasMany(Comment::class);
                                                                                          }
                                                                                          }