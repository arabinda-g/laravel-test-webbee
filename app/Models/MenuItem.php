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
        $child = 0;
        $child_flag = false;
        $changed = false;

        foreach ($menu_items as $item) {

            // Check if this is the first item
            if ($count == 0) {
                $new_menu_items[0] = $item;
                $new_menu_items[0]->children = [];
                $count++;
            } else {

                // Add item only if empty
                if (empty($new_menu_items[0]->children[$count])) {
                    $new_menu_items[0]->children[$count] = $item;
                    $new_menu_items[0]->children[$count]->children = [];
                }

                // Prevent adding the same item in children
                if ($child_flag) {
                    $new_menu_items[0]->children[$count]->children[] = $item;

                    // Check if this is the 2nd item
                    if ($child == 1) {
                        $count++;
                        $child = 0;
                        $child_flag = false;
                        $changed = true;
                    } else {
                        $child++;
                    }
                }

                // Check if child_flag has changed
                if ($changed) {
                    $changed = false;
                } else {
                    $child_flag = true;
                }
            }
        }

        return $menu_items;
    }
}
