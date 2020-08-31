<?php namespace App\Controllers;

use CodeIgniter\Controller;

Class Pages extends Controller
{
    public function index()
    {
        return view('welcome_message');
    }

    public function view($page = 'home')
    {
        
    }
}