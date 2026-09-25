<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->heading }} | {{ $settings->company_name ?? 'Xplore' }}</title>

    <!-- Favicon -->
    @if(!empty($settings->favicon))
        <link rel="icon" href="{{ asset($settings->favicon) }}" type="image/x-icon">
    @endif

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f8fafc;
            color: #334155;
            line-height: 1.7;
            padding-bottom: 2rem;
        }

        .webview-header {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: #ffffff;
            padding: 2.5rem 1rem;
            text-align: center;
            border-bottom: 4px solid #308e87;
        }

        .webview-logo {
            max-height: 65px;
            width: auto;
            margin-bottom: 1rem;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.15));
        }

        .page-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            border: 1px solid #e2e8f0;
            padding: 2.5rem;
            margin-top: -2rem;
        }

        @media (max-width: 576px) {
            .page-card {
                padding: 1.5rem;
                margin-top: -1.5rem;
                border-radius: 12px;
            }
            .webview-header {
                padding: 1.8rem 1rem;
            }
        }

        .page-content h1, .page-content h2, .page-content h3 {
            color: #0f172a;
            font-weight: 700;
            margin-top: 1.8rem;
            margin-bottom: 1rem;
        }

        .page-content h2 {
            font-size: 1.4rem;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 0.5rem;
        }

        .page-content p {
            margin-bottom: 1.2rem;
            color: #475569;
        }

        .page-content ul, .page-content ol {
            padding-left: 1.4rem;
            margin-bottom: 1.4rem;
        }

        .page-content li {
            margin-bottom: 0.5rem;
            color: #475569;
        }

        .contact-card {
            background-color: #f1f5f9;
            border-radius: 12px;
            padding: 1.25rem;
            height: 100%;
            transition: transform 0.2s ease;
        }

        .contact-card:hover {
            transform: translateY(-2px);
        }

        .contact-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: #308e87;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
        }

        .webview-footer {
            text-align: center;
            margin-top: 2rem;
            color: #94a3b8;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>

    <!-- Header Banner -->
    <header class="webview-header">
        <div class="container">
            @if(!empty($settings->logo))
                <img src="{{ asset($settings->logo) }}" alt="{{ $settings->company_name ?? 'Xplore' }}" class="webview-logo">
            @endif
            <h1 class="h3 fw-bold mb-1">
                @if($page->pagename == 'privacy_policy')
                    <i class="fas fa-shield-alt me-2 text-info"></i>
                @elseif($page->pagename == 'terms_conditions')
                    <i class="fas fa-file-contract me-2 text-warning"></i>
                @elseif($page->pagename == 'about_us')
                    <i class="fas fa-building me-2 text-success"></i>
                @elseif($page->pagename == 'contact_us')
                    <i class="fas fa-headset me-2 text-danger"></i>
                @else
                    <i class="fas fa-file-alt me-2 text-primary"></i>
                @endif
                {{ $page->heading }}
            </h1>
            <p class="text-white-50 small mb-0">{{ $settings->company_name ?? 'Xplore Mapping Services' }}</p>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="container">
        <div class="page-card">
            
            <!-- Contact Details Row if Contact Page -->
            @if($page->pagename == 'contact_us' && !empty($settings))
                <div class="row g-3 mb-4">
                    @if(!empty($settings->phone_no))
                        <div class="col-sm-6 col-md-3">
                            <div class="contact-card">
                                <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                                <h6 class="fw-bold mb-1">Call Us</h6>
                                <a href="tel:{{ $settings->phone_no }}" class="text-decoration-none text-primary small fw-bold">{{ $settings->phone_no }}</a>
                            </div>
                        </div>
                    @endif

                    @if(!empty($settings->email_id))
                        <div class="col-sm-6 col-md-3">
                            <div class="contact-card">
                                <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                                <h6 class="fw-bold mb-1">Email Us</h6>
                                <a href="mailto:{{ $settings->email_id }}" class="text-decoration-none text-primary small fw-bold">{{ $settings->email_id }}</a>
                            </div>
                        </div>
                    @endif

                    @if(!empty($settings->whatsapp_no))
                        <div class="col-sm-6 col-md-3">
                            <div class="contact-card">
                                <div class="contact-icon bg-success"><i class="fab fa-whatsapp"></i></div>
                                <h6 class="fw-bold mb-1">WhatsApp</h6>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp_no) }}" target="_blank" class="text-decoration-none text-success small fw-bold">{{ $settings->whatsapp_no }}</a>
                            </div>
                        </div>
                    @endif

                    @if(!empty($settings->address))
                        <div class="col-sm-6 col-md-3">
                            <div class="contact-card">
                                <div class="contact-icon bg-secondary"><i class="fas fa-map-marker-alt"></i></div>
                                <h6 class="fw-bold mb-1">Location</h6>
                                <p class="small text-muted mb-0">{{ $settings->address }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Page Body HTML -->
            <div class="page-content">
                {!! $page->description !!}
            </div>

        </div>

        <!-- Footer -->
        <footer class="webview-footer">
            <p class="mb-0">{{ $settings->copyright ?? ('© ' . date('Y') . ' All rights reserved by ' . ($settings->company_name ?? 'Xplore')) }}</p>
        </footer>
    </main>

</body>
</html>
