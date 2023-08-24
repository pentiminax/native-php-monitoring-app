<?php

namespace App\Providers;

use Native\Laravel\Facades\MenuBar;
use Native\Laravel\Menu\Menu;

class NativeAppServiceProvider
{
    public function boot(): void
    {
        $menu = Menu::new()
            ->label('Monitoring Menu Bar')
            ->separator()
            ->link('https://youtube.com/@Pentiminax', 'About')
            ->separator()
            ->quit();

        MenuBar::create()
            ->alwaysOnTop()
            ->icon(storage_path('app/public/menubarIcon.png'))
            ->maxHeight(200)
            ->maxWidth(400)
            ->height(200)
            ->width(400)
            ->withContextMenu($menu);
    }
}
