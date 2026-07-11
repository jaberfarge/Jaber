<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Scopes\TenantScope;

class Reply extends Model
{
    use HasFactory;

        protected static function booted()
            {
                    static::addGlobalScope(new TenantScope);
                        }

                            protected $fillable = [
                                    'tenant_id',
                                            'branch_id',
                                                    'review_id',
                                                            'generated_text',
                                                                    'published_text',
                                                                            'ai_model',
                                                                                    'prompt_version',
                                                                                            'quality_score',
                                                                                                    'is_published',
                                                                                                        ];

                                                                                                            protected $casts = [
                                                                                                                    'is_published' => 'boolean',
                                                                                                                        ];

                                                                                                                            public function review()
                                                                                                                                {
                                                                                                                                        return $this->belongsTo(Review::class);
                                                                                                                                            }

                                                                                                                                                public function tenant()
                                                                                                                                                    {
                                                                                                                                                            return $this->belongsTo(Tenant::class);
                                                                                                                                                                }

                                                                                                                                                                    public function branch()
                                                                                                                                                                        {
                                                                                                                                                                                return $this->belongsTo(Branch::class);
                                                                                                                                                                                    }
                                                                                                                                                                                    }