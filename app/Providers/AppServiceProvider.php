<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    public $category;

    public function register()
    {
    }

    public function boot()
    {
        $sql = "select * from category where parent_id=0 and status=1 order by category_name";
        $category = DB::select(DB::raw($sql));
        $category = json_decode(json_encode($category),true);
        foreach ($category as $key => $cat) {
            $category_id = $cat["id"];
            $sql = "select id,category_name from category where parent_id = $category_id";
            $result = DB::select(DB::raw($sql));
            $category[$key]["subcat"] = $result;
        }
        $this->category = json_decode(json_encode($category));
        view()->composer('student.layouts.sidebar', function($view) {
            $view->with(['category' => $this->category]);
        });
    }
}
