<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tenant extends Model
{
    use HasFactory;

        protected $fillable = [
                'place_id',
                        'name',
                                'google_types',
                                        'activity_type',
                                                'activity_status',
                                                        'user_ratings_total',
                                                                'rating',
                                                                        'is_chain',
                                                                                'chain_type',
                                                                                        'pricing_version',
                                                                                            ];

                                                                                                protected $casts = [
                                                                                                        'google_types' => 'array',
                                                                                                                'is_chain' => 'boolean',
                                                                                                                    ];

                                                                                                                        public function branches()
                                                                                                                            {
                                                                                                                                    return $this->hasMany(Branch::class);
                                                                                                                                        }
                                                                                                                                        }