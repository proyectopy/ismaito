<?php

namespace App\Providers\Filament;

use Filament\Forms\Components\Group;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class DashboardPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('dashboard')
            ->path('dashboard')
            ->login()
            //color hexadecimal para la app
            ->colors([
                'primary' => Color::hex('#BD0940'),
            ])
            //logo para modo claro y oscuro
            ->brandLogo(asset('images/logo.png'))
            ->darkModeBrandLogo(asset('images/logo_dark.png'))
            //Altura del logo
            ->brandLogoHeight('4rem')
            //barra de navegacion contraible
            ->sidebarCollapsibleOnDesktop()
            //ocultar breadcumbs
            ->breadcrumbs(true) //false oculto true mostrar
            //fuente personalizada
            ->font('Quicksand')
            //Enlaces al exterior
            ->navigationItems([
                NavigationItem::make('proyectopy.es')
                    ->url('https://proyectopy.es/', shouldOpenInNewTab:true)
                    ->icon('heroicon-o-link')
                    ->group('Links externos')
                    ->sort(2)
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                //Widgets\FilamentInfoWidget::class,
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
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
