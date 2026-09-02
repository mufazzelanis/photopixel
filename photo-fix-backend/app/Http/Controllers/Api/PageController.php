<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SitePayload;

class PageController extends Controller
{
    /** SEO meta for an arbitrary page key (home, about, contact, ...). */
    public function seo(string $key, SitePayload $payload)
    {
        return response()->json(['data' => $payload->seo($key)]);
    }

    /** Full content payload for the dedicated About Us page. */
    public function about(SitePayload $payload)
    {
        return response()->json($payload->aboutPage());
    }

    /** Copy + editable options for the Free Trial page form. */
    public function freeTrial(SitePayload $payload)
    {
        return response()->json($payload->freeTrialPage());
    }

    /** Copy + itemized per-service pricing tables for the Pricing page. */
    public function pricing(SitePayload $payload)
    {
        return response()->json($payload->pricingPage());
    }
}
