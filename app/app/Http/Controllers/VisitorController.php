<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function dashboard(){
        $page_name='Dashboard';
        $url='home';
        return view('visitor.dashboard',compact('page_name','url'));
    }
    public function book_visit(){
        $page_name='Dashboard';
        $url='book-visit';
        return view('visitor.dashboard',compact('page_name','url'));
    }
    public function my_visitors(){
        $page_name='My Visitors';
        $url='manage-visitor';
        return view('visitor.dashboard',compact('page_name','url'));
    }
    public function visitor_history(){
        $page_name='Visitor History';
        $url='visitor-history';
        return view('visitor.dashboard',compact('page_name','url'));
    }

    public function front_dashboard(){
        $page_name='Front Desk Dashboard';
        $url='front/dashboard';
        return view('visitor.dashboard',compact('page_name','url'));
    }

    public function front_bookVisit(){
        $page_name='Front Desk Book Visit';
        $url='front/book-visit';
        return view('visitor.dashboard',compact('page_name','url'));
    }

    public function admin_dashboard(){
        $page_name='Admin Dashboard';
        $url='dashboard';
        return view('visitor.dashboard',compact('page_name','url'));
    }

    public function admin_visitor_history(){
        $page_name='Admin Visitor History';
        $url='admin-visitor-history';
        return view('visitor.dashboard',compact('page_name','url'));
    }

    public function admin_manage_visitor(){
        $page_name='Admin Manage Visits';
        $url='admin-manage-history';
        return view('visitor.dashboard',compact('page_name','url'));
    }
}
