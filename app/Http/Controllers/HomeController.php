<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;

class HomeController extends Controller
{
    protected $noteModel;
    public function __construct()
    {
        $this->noteModel = new Note();
    }
    public function index()
    {
        try {
            $notes = $this->noteModel->getPublishedNotes();
            return view('home', ['notes' => $notes]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }       
    }
}
