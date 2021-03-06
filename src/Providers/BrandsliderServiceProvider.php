<?php

namespace Ar4ibyitsoftce\Brandslider\Providers;

use Illuminate\Support\ServiceProvider;
use DB;

class BrandsliderServiceProvider extends ServiceProvider
{

    public function boot(){
        $this->loadRoutesFrom(dirname(__DIR__).'/routes/web.php');
        $this->loadViewsFrom(dirname(__DIR__) . '/views', 'admin-slide');
        $this->loadMigrationsFrom(dirname(__DIR__) . '/migrations');

        $slider = DB::table('admin_menus')->where('name', 'Бренды')->first();
        if(is_null($slider)){
            DB::table('admin_menus')->insert([
                'admin_menu_id' => 5,
                'name' => 'Бренды',
                'icon' => 'fa-image',
                'route' => 'admin.slider-brand.index',
                'o' => 0
            ]);
        }
    }

    public function register(){
        //
    }

}