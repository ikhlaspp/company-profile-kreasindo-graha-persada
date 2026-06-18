<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Setting keys grouped by tab, with their input type. Keys mengikuti skema
     * seeder/situs publik (site_*, contact_*, social_*, company_*, chatbot_*).
     *
     * @var array<string, string>
     */
    private const KEYS = [
        'site_name' => 'text',
        'site_tagline' => 'text',
        'contact_address' => 'text',
        'contact_phone' => 'text',
        'contact_whatsapp' => 'text',
        'contact_email' => 'text',
        'contact_hours' => 'text',
        'company_history' => 'text',
        'company_vision' => 'text',
        'company_mission' => 'text',
        'social_instagram' => 'text',
        'social_linkedin' => 'text',
        'social_facebook' => 'text',
        'social_youtube' => 'text',
        'chatbot_greeting' => 'text',
        'chatbot_enabled' => 'boolean',
        'logo' => 'image',
    ];

    /** Group per prefix — dipakai query publik (layouts/app, about, chatbot). */
    private const GROUPS = [
        'site_' => 'general',
        'contact_' => 'contact',
        'company_' => 'company',
        'social_' => 'social',
        'chatbot_' => 'chatbot',
    ];

    public function edit(): View
    {
        $stored = Setting::pluck('value', 'key')->all();

        $settings = collect(self::KEYS)
            ->map(fn ($type, $key) => $stored[$key] ?? '')
            ->all();

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'site_name' => ['nullable', 'string', 'max:255'],
            'site_tagline' => ['nullable', 'string', 'max:255'],
            'contact_address' => ['nullable', 'string', 'max:500'],
            'contact_phone' => ['nullable', 'string', 'max:100'],
            'contact_whatsapp' => ['nullable', 'string', 'max:100'],
            'contact_email' => ['nullable', 'email', 'max:150'],
            'contact_hours' => ['nullable', 'string', 'max:150'],
            'company_history' => ['nullable', 'string', 'max:2000'],
            'company_vision' => ['nullable', 'string', 'max:1000'],
            'company_mission' => ['nullable', 'string', 'max:2000'],
            'social_instagram' => ['nullable', 'string', 'max:150'],
            'social_linkedin' => ['nullable', 'string', 'max:255'],
            'social_facebook' => ['nullable', 'string', 'max:255'],
            'social_youtube' => ['nullable', 'string', 'max:255'],
            'chatbot_greeting' => ['nullable', 'string', 'max:500'],
            'chatbot_enabled' => ['nullable', 'boolean'],
            'logo' => ['nullable', 'image', 'max:5120'],
        ]);

        foreach (self::KEYS as $key => $type) {
            if ($key === 'logo') {
                if ($request->hasFile('logo')) {
                    $this->put('logo', $request->file('logo')->store('settings', 'public'), 'image');
                }

                continue;
            }

            $value = $key === 'chatbot_enabled'
                ? (string) $request->boolean('chatbot_enabled')
                : ($data[$key] ?? null);

            $this->put($key, $value, $type);
        }

        Cache::forget('chatbot.system_prompt');
        Cache::forget('chatbot.widget_settings');

        return redirect()->route('panel.settings.edit')->with('success', 'Pengaturan berhasil disimpan.');
    }

    private function put(string $key, ?string $value, string $type): void
    {
        $group = 'general';

        foreach (self::GROUPS as $prefix => $candidate) {
            if (str_starts_with($key, $prefix)) {
                $group = $candidate;
                break;
            }
        }

        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type, 'group' => $group],
        );
    }
}
