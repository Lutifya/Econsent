<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class MenuConstructor{
    public $menu;
    public function __construct($menu){
        $this->menu = $menu;
    }
}

class MenuServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // get all data from menu.json file
        $test2 = DB::table('menu')->orderBy('ordine')->where('deleted_at', '=', null)->where('parent_id')->get();
        $array = array();

        foreach ($test2 as $menu){
            $Figli = DB::table('menu')->orderBy('ordine')->where('deleted_at', '=', null)->where('parent_id', $menu->id)->get();
            $valori = [];
            $header = [];
            if($menu->idNavheader !== null){
                $row = DB::table('nav_header')->where('id', $menu->idNavheader)->first();
                isset($row->navheader) ? $header["navheader"] = $row->navheader : '';
                isset($row->slug) ? $header["slug"] = $row->slug : '';
                array_push($array, $header);
            }

            isset($menu->url) ? $valori["url"] = $menu->url : '';
            isset($menu->icon) ? $valori["icon"] = $menu->icon : '';
            isset($menu->name) ? $valori["name"] = $menu->name : '';
            isset($menu->slug) ? $valori["slug"] = $menu->slug : '';
            isset($menu->badge) ? $valori["badge"] = $menu->badge : '';
            isset($menu->role) ? $valori["role"] = $menu->role : '';
            isset($menu->badgeClass) ? $valori["badgeClass"] = $menu->badgeClass : '';
            isset($menu->newTab) ? $valori["newTab"] = $menu->newTab : '';
            $valori["hideHorizontal"] = $menu->hideHorizontal ?? '';

            if(count($Figli) !== 0 ){
                $valori["SubMenu"] = $this->subMenu($menu->id);
            }

            $array[] = $valori;
        }

        $Menu2 =new MenuConstructor($array);

//        $verticalMenuJson = file_get_contents(base_path('resources/data/menu-data/verticalMenu.json'));
//        $verticalMenuData = json_decode($verticalMenuJson);
        $verticalMenuData = $Menu2;
//        $horizontalMenuJson = file_get_contents(base_path('resources/data/menu-data/horizontalMenu.json'));
//        $horizontalMenuData = json_decode($horizontalMenuJson);
        $horizontalMenuData = $Menu2;
        // Share all menuData to all the views
        \View::share('menuData',[$verticalMenuData, $horizontalMenuData]);
    }

    private function subMenu($parentId){
        $menus = DB::table('menu')->orderBy('ordine')->where('deleted_at', '=', null)->where('parent_id', $parentId)->get();
        $subMenu = array();
        foreach ($menus as $menu){
            $Figli = DB::table('menu')->where('parent_id', $menu->id)->get();
            $valori = [];
            isset($menu->url) ? $valori["url"] = $menu->url : '';
            isset($menu->icon) ? $valori["icon"] = $menu->icon : '';
            isset($menu->name) ? $valori["name"] = $menu->name : '';
            isset($menu->slug) ? $valori["slug"] = $menu->slug : '';
            isset($menu->badge) ? $valori["badge"] = $menu->badge : '';
            isset($menu->role) ? $valori["role"] = $menu->role : '';
            isset($menu->badgeClass) ? $valori["badgeClass"] = $menu->badgeClass : '';
            isset($menu->newTab) ? $valori["newTab"] = $menu->newTab : '';
            isset($menu->hideHorizontal) ? $valori["hideHorizontal"] = $menu->hideHorizontal : '';

            if(count($Figli) !== 0 ){
                $valori["SubMenu"] = $this->subMenu($menu->id);
            }
            array_push($subMenu, $valori);
        }
        return $subMenu;
    }
}
