<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $routes = Route::getRoutes();

        foreach ($routes as $route) {
            $methods = array_diff($route->methods(), ['HEAD']);
            $name = $route->getName();
            $methods = $route->methods();
            $uri = $route->uri();
            $action = $route->getActionName();

            if ($name) {
                foreach ($methods as $method) {
                    $method !== 'HEAD' &&
                    Permission::firstOrCreate([
                        'name' => $name,
                        'method' => $method,
                        "action" => $action,
                        'uri' => $uri,
                        'slug' => str_replace('.', '-', strtolower($name)),
                        
                    ]);
                }
            }
        }
    }
}
