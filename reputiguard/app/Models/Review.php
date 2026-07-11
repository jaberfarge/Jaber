<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Scopes\TenantScope;

class Review extends Model
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
                                                            'rating',
                                                                    'raw_text',
                                                                            'cleaned_text',
                                                                                    'language',
                                                                                            'sentiment',
                                                                                                    'risk_level',
                                                                                                            'is_sensitive',
                                                                                                                    'review_time',
                                                                                                                        ];

                                                                                                                            protected $casts = [
                                                                                                                                    'is_sensitive' => 'boolean',
                                                                                                                                            'review_time' => 'datetime',
                                                                                                                                                ];

                                                                                                                                                    public function tenant()
                                                                                                                                                        {
                                                                                                                                                                return $this->belongsTo(Tenant::class);
                                                                                                                                                                    }

                                                                                                                                                                        public function branch()
                                                                                                                                                                            {
                                                                                                                                                                                    return $this->belongsTo(Branch::class);
                                                                                                                                                                                        }

                                                                                                                                                                                            public function reply()
                                                                                                                                                                                                {
                                                                                                                                                                                                        return $this->hasOne(Reply::class);
                                                                                                                                                                                                            }
                                                                                                                                                                                                            }