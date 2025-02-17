<?php

namespace App\Providers;

use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
        Notification::configureUsing(function (Notification $notification): void {
            $notification->view('filament.notifications.notification');
        });
        FilamentColor::register([
            'textial' => Color::hex('#01cfff'),
            'textial1' => Color::hex('#ff63ba'),
            'textial2' => Color::hex('#ffffff'),
            'textial3' => Color::hex('#000000'),
            'textial4' => Color::hex('#333333'),
            'textial5' => Color::hex('#ff9900'),
            'textial6' => Color::hex('#ffcc00'),
            'textial7' => Color::hex('#ffff00'),
            'primary' => Color::hex('#ff63ba'),
        ]);
    }


}
