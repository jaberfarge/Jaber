<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternalAuditLog extends Model
{
    public $timestamps = false;

        protected $fillable = [
                'action',
                        'user',
                                'ip',
                                        'device',
                                                'browser',
                                                        'details',
                                                            ];

                                                                protected $casts = [
                                                                        'details' => 'array',
                                                                            ];
                                                                            }