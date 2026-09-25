<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cms;
use App\Models\WebSettings;

class PageController extends Controller
{
    /**
     * Display the specified CMS page web view.
     */
    public function show($slug)
    {
        // Normalize slug: replace dashes with underscores
        $normalizedSlug = str_replace('-', '_', strtolower($slug));

        // Mapping variations
        $slugMap = [
            'terms_and_conditions' => 'terms_conditions',
            'terms'                => 'terms_conditions',
            'privacy'              => 'privacy_policy',
            'about'                => 'about_us',
            'contact'              => 'contact_us',
        ];

        $targetPageName = $slugMap[$normalizedSlug] ?? $normalizedSlug;

        $page = Cms::where('pagename', $targetPageName)
            ->orWhere('pagename', $slug)
            ->where('status', 'Active')
            ->first();

        if (!$page) {
            // Fallback search by heading/pagename without status if active fails or try first match
            $page = Cms::where('pagename', 'LIKE', '%' . $normalizedSlug . '%')
                ->where('status', 'Active')
                ->first();
        }

        if (!$page) {
            abort(404, 'Page not found');
        }

        $settings = WebSettings::first();

        return view('page.show', compact('page', 'settings'));
    }

    public function privacyPolicy()
    {
        return $this->show('privacy_policy');
    }

    public function termsConditions()
    {
        return $this->show('terms_conditions');
    }

    public function aboutUs()
    {
        return $this->show('about_us');
    }

    public function contactUs()
    {
        return $this->show('contact_us');
    }
}
