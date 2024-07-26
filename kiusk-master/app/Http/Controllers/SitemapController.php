<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Sitemap\SitemapGenerator;

class SitemapController extends Controller
{
    public function index()
    {
        return SitemapGenerator::create('https://kiusk.ca')->writeToFile(public_path('sitemap.xml'));
    }
}
