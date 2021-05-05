<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use stdClass;

class MenuItem extends Model
{

    public function getMenuItems()
    {
        $menu_items = DB::table('menu_items')->get();

        $new_menu_items = [];
        $count = 0;
        $index1 = 0;
        $index2 = 0;
        foreach ($menu_items as $key => $item) {
            if ($count == 0) {
                $new_menu_items[$index1] = $item;
                $new_menu_items[$index1]->children = [];
                $count++;
            } else if ($count <= 2) {
                $new_menu_items[$index1]->children[$index2] = $item;
                $new_menu_items[$index1]->children[$index2]->children = [];


                $index2++;
                $count++;
            } else if ($count > 2 && $count <= 4) {
                // dd($new_menu_items[$index1]->children[$index2]);
                // var_dump($count, $index1, $index2);

                $new_menu_items[$index1]->children[$index2]->children = $item;

                $index2++;
                $count++;
            } else {
                $index1++;
                // $index2++;
                $count = 0;
            }

            if ($count == 3) {
                $index2 = 0;
            }
        }
        // dd($new_menu_items);
        return $menu_items;
    }
}
