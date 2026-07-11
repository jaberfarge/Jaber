<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Tenant;
use App\Models\Branch;

class GooglePlacesService
{
    protected string $apiKey;

        public function __construct(?string $apiKey = null)
            {
                    $this->apiKey = $apiKey ?? config('services.google.places_key');
                        }

                            public function fetchPlaceDetails(string $placeId): array
                                {
                                        $response = Http::get(
                                                    'https://maps.googleapis.com/maps/api/place/details/json',
                                                                [
                                                                                'place_id' => $placeId,
                                                                                                'key' => $this->apiKey,
                                                                                                                'language' => 'ar',
                                                                                                                            ]
                                                                                                                                    );

                                                                                                                                            return $response->json()['result'] ?? [];
                                                                                                                                                }

                                                                                                                                                    public function createTenantFromGoogle(string $placeId): Tenant
                                                                                                                                                        {
                                                                                                                                                                $data = $this->fetchPlaceDetails($placeId);

                                                                                                                                                                        return Tenant::create([
                                                                                                                                                                                    'place_id' => $placeId,
                                                                                                                                                                                                'name' => $data['name'] ?? 'Unknown',
                                                                                                                                                                                                            'google_types' => $data['types'] ?? [],
                                                                                                                                                                                                                        'activity_status' => $data['business_status'] ?? 'active',
                                                                                                                                                                                                                                    'user_ratings_total' => $data['user_ratings_total'] ?? 0,
                                                                                                                                                                                                                                                'rating' => $data['rating'] ?? 0,
                                                                                                                                                                                                                                                            'pricing_version' => 'v1',
                                                                                                                                                                                                                                                                    ]);
                                                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                                                            public function createBranchFromGoogle(Tenant $tenant, string $placeId): Branch
                                                                                                                                                                                                                                                                                {
                                                                                                                                                                                                                                                                                        $data = $this->fetchPlaceDetails($placeId);

                                                                                                                                                                                                                                                                                                return Branch::create([
                                                                                                                                                                                                                                                                                                            'tenant_id' => $tenant->id,
                                                                                                                                                                                                                                                                                                                        'place_id' => $placeId,
                                                                                                                                                                                                                                                                                                                                    'name' => $data['name'] ?? 'Unknown Branch',
                                                                                                                                                                                                                                                                                                                                                'address' => $data['formatted_address'] ?? null,
                                                                                                                                                                                                                                                                                                                                                            'user_ratings_total' => $data['user_ratings_total'] ?? 0,
                                                                                                                                                                                                                                                                                                                                                                        'rating' => $data['rating'] ?? 0,
                                                                                                                                                                                                                                                                                                                                                                                ]);
                                                                                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                                                                                    }