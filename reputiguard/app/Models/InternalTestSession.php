<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\TenantScope;

class InternalTestSession extends Model
{
    protected $fillable = [
            'tenant_id', // إضافة هامة لعمل الـ TenantScope
                    'session_type',
                            'active',
                                    'parameters',
                                            'reset_after_test',
                                                ];

                                                    protected $casts = [
                                                            'active' => 'boolean',
                                                                    'parameters' => 'array',
                                                                            'reset_after_test' => 'boolean',
                                                                                ];

                                                                                    /**
                                                                                         * تفعيل الـ Global Scope تلقائياً لهذا الموديل
                                                                                              */
                                                                                                  protected static function booted()
                                                                                                      {
                                                                                                              static::addGlobalScope(new TenantScope);
                                                                                                                  }
                                                                                                                  }
                                                                                                                  