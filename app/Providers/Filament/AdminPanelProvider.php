<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\Widgets;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Blade;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin; 
use App\Models\CompanyProfile;

// Import Widget Statistik & Grafik (Pastikan file widget ini ada di app/Filament/Widgets)
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\NewsChart;
use App\Filament\Widgets\CategoryChart;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admingaungredaksi')
            ->login()
            
            // === 1. BRANDING & LOGO ===
            ->brandName('') 
            ->brandLogo(function () {
                $company = CompanyProfile::first();
                $logoUrl = ($company && $company->logo) ? Storage::url($company->logo) : null;
                $html = $logoUrl 
                    ? '<img src="'.$logoUrl.'" alt="Logo" class="h-10 w-auto object-contain hover:scale-105 transition-transform duration-500">' 
                    : '<div class="flex items-center gap-2 font-bold text-xl text-slate-800 dark:text-white"><div class="bg-gradient-to-br from-[#D32F2F] to-[#b71c1c] text-white w-9 h-9 flex items-center justify-center rounded-xl shadow-lg shadow-red-500/30">GR</div><span>GAUNG<span class="text-[#D32F2F]">REDAKSI</span></span></div>';
                return new HtmlString($html);
            })
            ->brandLogoHeight('3rem')
            ->favicon(asset('images/gaungnusra.png'))
            ->colors([
                'primary' => '#D32F2F', 
                'gray'    => Color::Slate,
            ])
            ->font('Plus Jakarta Sans')
            ->maxContentWidth(MaxWidth::Full)
            ->sidebarCollapsibleOnDesktop()
            
            // === 2. CSS MODERN (DIPERTAHANKAN) ===
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): string => Blade::render(<<<'HTML'
                    <style>
                        /* GLOBAL VARIABLES */
                        :root {
                            --brand-red: #D32F2F;
                            --brand-red-dark: #b71c1c;
                            --brand-glow: rgba(211, 47, 47, 0.4);
                            --glass-bg: rgba(255, 255, 255, 0.85);
                            --glass-blur: 20px;
                        }
                        
                        /* SCROLLBAR */
                        ::-webkit-scrollbar { width: 6px; height: 6px; }
                        ::-webkit-scrollbar-track { background: transparent; }
                        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
                        ::-webkit-scrollbar-thumb:hover { background: var(--brand-red); }

                        body {
                            background-color: #f8fafc;
                            background-image: radial-gradient(circle at top right, rgba(211, 47, 47, 0.03) 0%, transparent 40%),
                                              radial-gradient(circle at bottom left, rgba(30, 58, 138, 0.03) 0%, transparent 40%);
                        }

                        /* SIDEBAR GLASSMORPHISM */
                        .fi-sidebar {
                            background-color: var(--glass-bg) !important;
                            backdrop-filter: blur(var(--glass-blur)) !important;
                            border-right: 1px solid rgba(0,0,0,0.05) !important;
                            box-shadow: 20px 0 40px rgba(0,0,0,0.02) !important;
                        }
                        
                        /* SIDEBAR ITEMS */
                        .fi-sidebar-item { margin-bottom: 4px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
                        .fi-sidebar-item-button {
                            border-radius: 12px !important;
                            font-weight: 600 !important;
                            transition: all 0.3s ease;
                        }
                        .fi-sidebar-item-button:hover {
                            background: rgba(211, 47, 47, 0.05) !important;
                            transform: translateX(4px);
                        }
                        .fi-sidebar-item-active .fi-sidebar-item-button {
                            background: linear-gradient(135deg, var(--brand-red), var(--brand-red-dark)) !important;
                            color: white !important;
                            box-shadow: 0 8px 20px var(--brand-glow) !important;
                        }
                        .fi-sidebar-item-active .fi-sidebar-item-button span, 
                        .fi-sidebar-item-active .fi-sidebar-item-button svg { color: white !important; }

                        /* TOPBAR */
                        .fi-topbar {
                            background-color: rgba(255, 255, 255, 0.8) !important;
                            backdrop-filter: blur(var(--glass-blur)) !important;
                            border-bottom: 1px solid rgba(0,0,0,0.05) !important;
                            position: sticky; top: 0; z-index: 40;
                        }

                        /* CARDS & WIDGETS */
                        .fi-section, .fi-widget, .fi-sc-card {
                            background: white !important;
                            border-radius: 20px !important;
                            border: 1px solid rgba(0,0,0,0.03) !important;
                            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02) !important;
                            transition: transform 0.3s ease, box-shadow 0.3s ease !important;
                        }
                        .fi-section:hover, .fi-widget:hover {
                            transform: translateY(-3px);
                            box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.05) !important;
                        }

                        /* BUTTONS */
                        .fi-btn-primary {
                            background-image: linear-gradient(135deg, var(--brand-red), var(--brand-red-dark)) !important;
                            border: none !important;
                            box-shadow: 0 4px 15px var(--brand-glow) !important;
                            border-radius: 10px !important;
                        }
                    </style>
                HTML)
            )

            // === 3. HEADER DASHBOARD SUDAH DIHAPUS (BERSIH) ===

            // === 4. CONFIG PLUGIN & WIDGET ===
            ->plugins([ FilamentShieldPlugin::make() ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([ Pages\Dashboard::class ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            
          ->widgets([
                // Baris 1: Statistik Utama (Full)
                \App\Filament\Widgets\StatsOverview::class,

                // Baris 2: Grafik Tren & Status (Berdampingan)
                \App\Filament\Widgets\NewsChart::class,       // Kiri
                \App\Filament\Widgets\NewsStatusChart::class, // Kanan

                // Baris 3: Tabel Berita & Grafik Kategori (Berdampingan)
                \App\Filament\Widgets\LatestNewsWidget::class, // Kiri
                \App\Filament\Widgets\CategoryChart::class,    // Kanan
            ])
            
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([ Authenticate::class ]);
    }
}