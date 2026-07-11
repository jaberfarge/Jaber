<?php

namespace App\Services;

use App\Models\Review;
use App\Models\Branch;
use App\Models\Tenant;

class ReviewImportService
{
    public function importReviews(Tenant $tenant, Branch $branch, array $reviews): void
        {
                foreach ($reviews as $reviewData) {
                            Review::updateOrCreate(
                                            [
                                                                'review_id' => $reviewData['review_id'],
                                                                                ],
                                                                                                [
                                                                                                                    'tenant_id'     => $tenant->id,
                                                                                                                                        'branch_id'     => $branch->id,
                                                                                                                                                            'rating'        => $reviewData['rating'] ?? 0,
                                                                                                                                                                                'raw_text'      => $reviewData['text'] ?? '',
                                                                                                                                                                                                    'cleaned_text'  => $reviewData['cleaned_text'] ?? null,
                                                                                                                                                                                                                        'language'      => $reviewData['language'] ?? null,
                                                                                                                                                                                                                                            'sentiment'     => $reviewData['sentiment'] ?? null,
                                                                                                                                                                                                                                                                'risk_level'    => $reviewData['risk_level'] ?? null,
                                                                                                                                                                                                                                                                                    'is_sensitive'  => $reviewData['is_sensitive'] ?? false,
                                                                                                                                                                                                                                                                                                        'review_time'   => $reviewData['time'] ?? null,
                                                                                                                                                                                                                                                                                                                        ]
                                                                                                                                                                                                                                                                                                                                    );
                                                                                                                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                                                                }