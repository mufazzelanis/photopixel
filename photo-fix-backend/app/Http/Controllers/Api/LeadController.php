<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ContactFormRequest;
use App\Http\Requests\Api\FreeTrialFormRequest;
use App\Http\Requests\Api\QuoteFormRequest;
use App\Http\Requests\Api\SubscribeFormRequest;
use App\Models\ContactMessage;
use App\Models\FreeTrialRequest;
use App\Models\NewsletterSubscriber;
use App\Models\QuoteRequest;
use App\Models\SiteSetting;
use App\Notifications\LeadReceived;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class LeadController extends Controller
{
    public function quote(QuoteFormRequest $request): JsonResponse
    {
        $lead = QuoteRequest::create($request->safe()->except(['website', 'recaptcha_token']) + [
            'source' => $request->headers->get('referer'),
            'ip' => $request->ip(),
        ]);

        $this->notifyAdmin($lead, 'Quote Request');

        return response()->json(['message' => "Thanks! We've received your request and will reply shortly."], 201);
    }

    public function contact(ContactFormRequest $request): JsonResponse
    {
        $lead = ContactMessage::create($request->safe()->except(['website', 'recaptcha_token']) + ['ip' => $request->ip()]);
        $this->notifyAdmin($lead, 'Contact Message');

        return response()->json(['message' => "Thanks for reaching out — we'll be in touch soon."], 201);
    }

    public function freeTrial(FreeTrialFormRequest $request): JsonResponse
    {
        $data = $request->safe()->except(['website', 'samples', 'recaptcha_token']);

        $lead = FreeTrialRequest::create($data + ['ip' => $request->ip()]);

        foreach ((array) $request->file('samples', []) as $file) {
            $lead->addMedia($file)->toMediaCollection('samples');
        }

        $this->notifyAdmin($lead, 'Free Trial Request');

        return response()->json(['message' => 'Your free trial request is in! Expect your samples soon.'], 201);
    }

    public function subscribe(SubscribeFormRequest $request): JsonResponse
    {
        NewsletterSubscriber::updateOrCreate(
            ['email' => $request->string('email')->lower()->value()],
            ['token' => Str::random(40), 'unsubscribed_at' => null],
        );

        return response()->json(['message' => "You're subscribed. Watch your inbox for editing tips."], 201);
    }

    private function notifyAdmin(object $lead, string $label): void
    {
        $to = SiteSetting::value('contact', 'quote_notify_email')
            ?: SiteSetting::value('contact', 'email');

        if ($to) {
            Notification::route('mail', $to)->notify(new LeadReceived($lead, $label));
        }
    }
}
