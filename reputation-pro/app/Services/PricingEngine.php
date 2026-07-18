<?php

namespace App\Services;

class PricingEngine {
    protected $multipliers = [
            'hospital' => 1.70, 'hotel' => 1.40, 'clinic' => 1.30,
                    'restaurant' => 1.20, 'cafe' => 1.10, 'store' => 1.00
                        ];

                            public function calculateTier($googleType, $monthlyReviews = 0) {
                                    $typeMult = $this->multipliers[$googleType] ?? 1.00;
                                            $usageMult = $monthlyReviews > 50 ? 1.20 : 1.00;
                                                    return min(2.0, round($typeMult * $usageMult, 1));
                                                        }
                                                        }