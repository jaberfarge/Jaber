<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Scopes\TenantScope;

class Branch extends Model
{
    use HasFactory;

        protected static function booted()
            {
                    static::addGlobalScope(new TenantScope);
                        }

                            protected $fillable = [
                                    'tenant_id',
                                            'place_id',
                                                    'name',
                                                            'address',
                                                                    'user_ratings_total',
                                                                            'rating',
                                                                                    'branch_size',
                                                                                        ];

                                                                                            public function tenant()
                                                                                                {
                                                                                                        return $this->belongsTo(Tenant::class);
                                                                                                            }

                                                                                                                public function reviews()
                                                                                                                    {
                                                                                                                            return $this->hasMany(Review::class);
                                                                                                                                }
                                                                                                                                }