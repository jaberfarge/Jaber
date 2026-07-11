<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\TenantScope;

class InternalSecurityEvent extends Model
{
    protected static function booted()
        {
                static::addGlobalScope(new TenantScope);
                    }

                        protected $fillable = [
                                'tenant_id',
                                        'event_type',
                                                'user',
                                                        'ip',
                                                                'device',
                                                                        'browser',
                                                                                'details',
                                                                                    ];

                                                                                        protected $casts = [
                                                                                                'details' => 'array',
                                                                                                    ];

                                                                                                        public function tenant()
                                                                                                            {
                                                                                                                    return $this->belongsTo(Tenant::class);
                                                                                                                        }
                                                                                                                        }