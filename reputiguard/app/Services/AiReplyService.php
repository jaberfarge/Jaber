<?php

namespace App\Services;

use App\Models\Reply;
use App\Models\Review;
use App\Models\Tenant;
use App\Models\Branch;

class AiReplyService
{
    public function generateReply(Tenant $tenant, Branch $branch, Review $review): Reply
        {
                $generatedText = $this->buildPlaceholderReply($tenant, $branch, $review);

                        return Reply::updateOrCreate(
                                    [
                                                    'review_id' => $review->id,
                                                                ],
                                                                            [
                                                                                            'tenant_id'         => $tenant->id,
                                                                                                            'branch_id'         => $branch->id,
                                                                                                                            'generated_text'    => $generatedText,
                                                                                                                                            'published_text'    => null,
                                                                                                                                                            'ai_model'          => 'placeholder-gemini',
                                                                                                                                                                            'prompt_version'    => 'v1',
                                                                                                                                                                                            'quality_score'     => null,
                                                                                                                                                                                                            'is_published'      => false,
                                                                                                                                                                                                                        ]
                                                                                                                                                                                                                                );
                                                                                                                                                                                                                                    }

                                                                                                                                                                                                                                        protected function buildPlaceholderReply(Tenant $tenant, Branch $branch, Review $review): string
                                                                                                                                                                                                                                            {
                                                                                                                                                                                                                                                    return sprintf(
                                                                                                                                                                                                                                                                'شكراً لك على تقييمك لنشاط %s (فرع %s). تم تسجيل ملاحظتك: "%s". هذا رد تجريبي وسيتم استبداله برد فعلي من نموذج الذكاء الاصطناعي لاحقاً.',
                                                                                                                                                                                                                                                                            $tenant->name,
                                                                                                                                                                                                                                                                                        $branch->name,
                                                                                                                                                                                                                                                                                                    $review->raw_text
                                                                                                                                                                                                                                                                                                            );
                                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                                }