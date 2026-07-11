<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnknownActivity extends Model
{
    protected $fillable = [
            'place_id',
                    'name',
                            'google_types',
                                    'appearance_count',
                                            'admin_notified',
                                                    'manual_mapping_allowed',
                                                        ];

                                                            protected $casts = [
                                                                    'google_types' => 'array',
                                                                            'admin_notified' => 'boolean',
                                                                                    'manual_mapping_allowed' => 'boolean',
                                                                                        ];
                                                                                        }