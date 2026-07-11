<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Scopes\TenantScope;

class InternalPreviewBusiness extends Model
{
    use HasFactory;

        protected static function booted()
            {
                    static::addGlobalScope(new TenantScope);
                        }

                            protected $fillable = [
                                    'tenant_id',
                                            'owner_visible_only',
                                                    'generate_without_publish',
                                                            'store_results_only',
                                                                    'compare_ai_versions',
                                                                        ];

                                                                            protected $casts = [
                                                                                    'owner_visible_only' => 'boolean',
                                                                                            'generate_without_publish' => 'boolean',
                                                                                                    'store_results_only' => 'boolean',
                                                                                                            'compare_ai_versions' => 'boolean',
                                                                                                                ];

                                                                                                                    public function tenant()
                                                                                                                        {
                                                                                                                                return $this->belongsTo(Tenant::class);
                                                                                                                                    }
                                                                                                                                    }