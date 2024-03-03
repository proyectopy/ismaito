<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use App\Models\City;
use Filament\Widgets;
use Filament\PanelProvider;
use App\Filament\Pages\Profile;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Filament\Forms\Components\Group;
use Filament\Navigation\UserMenuItem;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\NavigationGroup;
use Filament\Http\Middleware\Authenticate;
use Awcodes\FilamentGravatar\GravatarPlugin;
use Awcodes\FilamentGravatar\GravatarProvider;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Swis\Filament\Backgrounds\ImageProviders\MyImages;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Swis\Filament\Backgrounds\FilamentBackgroundsPlugin;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin;

class DashboardPanelProvider extends PanelProvider
{
    // public static function getNavigationBadge(): ?string
    //             {
    //                 return 'NEW';
    //             }
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('dashboard')
            ->path('dashboard')
            ->login()
            ->registration()
            ->passwordReset()
            ->emailVerification()
            ->profile()
            //color hexadecimal para la app
            ->colors([
                'primary' => Color::hex('#BD0940'),
            ])
            ->plugin(FilamentSpatieLaravelBackupPlugin::make())
            ->plugin(FilamentBackgroundsPlugin::make()
            ->showAttribution(false)
            ->imageProvider(
                MyImages::make()
                    ->directory('images/fondos')
            ),)
            //mostrar gravatar
            ->defaultAvatarProvider(GravatarProvider::class)
            ->plugins([
                GravatarPlugin::make()
                ->default('robohash')
                ->size(200)
                ->rating('pg'),
            ])
            //prueba

            //fin prueba
            //favicon
            ->favicon(asset('images/favicon.png'))
            //logo para modo claro y oscuro
            ->brandLogo(asset('images/logo.png'))
            ->darkModeBrandLogo(asset('images/logo_dark.png'))
            //Altura del logo
            ->brandLogoHeight(fn () => auth()->check() ? '4rem' : '6rem')
            //barra de navegacion contraible
            ->sidebarCollapsibleOnDesktop()
            //ocultar breadcumbs
            ->breadcrumbs(true) //false oculto true mostrar
            //fuente personalizada
            ->font('Quicksand')
            //Enlaces al exterior
            ->navigationItems([
                NavigationItem::make('Mi Web')
                    ->url('https://proyectopy.es/', shouldOpenInNewTab:true)
                    ->icon('heroicon-m-globe-alt')
                    ->group('Links externos')
                    ->sort(100),
                NavigationItem::make('Mi Github')
                    ->url('https://github.com/proyectopy', shouldOpenInNewTab:true)
                    ->icon('carbon-logo-github')
                    ->group('Links externos')
                    ->sort(101),
                NavigationItem::make('Youtube.')
                    ->url('https://www.youtube.com/playlist?list=PLbFjjy1sD3hqpbPGYP9bxwyd2B79V09kV', shouldOpenInNewTab:true)
                    ->icon('carbon-logo-youtube')
                    ->group('Tutorial')
                    ->sort(103),
                NavigationItem::make('Codigo fuente.')
                    ->url('https://github.com/elrincondeisma/curso-filamentphp-intranet', shouldOpenInNewTab:true)
                    ->icon('carbon-ibm-watsonx-code-assistant-for-z-refactor')
                    ->group('Tutorial')
                    ->sort(103),
            ])
            //añadir items al menu de usuario
            ->userMenuItems([
                MenuItem::make()
                ->label('Configuración')
                ->url('')
                ->icon('heroicon-o-cog-6-tooth'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                // Stat::make('Ciudades Registradas', City::query()->count()),
                //Widgets\FilamentInfoWidget::class,
                Widgets\PersonalInfoWidget::class,

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
