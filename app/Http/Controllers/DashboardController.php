<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Sample data for the dashboard
        $stats = [
            'brands' => 24,
            'categories' => 18,
            'items' => 124,
            'recent' => 16,
        ];

        $recentItems = [
            ['name' => 'iPhone 13 Pro', 'category' => 'Electronics', 'brand' => 'Apple', 'code' => 'ITM001', 'time' => '2 hours ago'],
            ['name' => 'Air Max Shoes', 'category' => 'Clothing', 'brand' => 'Nike', 'code' => 'ITM002', 'time' => '5 hours ago'],
            ['name' => 'Galaxy S21', 'category' => 'Electronics', 'brand' => 'Samsung', 'code' => 'ITM003', 'time' => 'Today'],
        ];

        $chartData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            'data' => [18, 25, 22, 30, 27, 35, 42]
        ];

        $categoryData = [
            'Electronics' => 35,
            'Clothing' => 25,
            'Home & Kitchen' => 20,
            'Sports' => 15,
            'Books' => 5
        ];

        return view('dashboard', compact('stats', 'recentItems', 'chartData', 'categoryData'));
    }

    public function brands()
    {
        return view('brands');
    }

    public function categories()
    {
        return view('categories');
    }

    public function items()
    {
        return view('items');
    }
}
