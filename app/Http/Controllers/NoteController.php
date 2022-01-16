<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Project;
use Session;

class NoteController extends Controller
{
    protected $projectModel;
    protected $noteModel;
    public function __construct()
    {
        $this->projectModel = new Project();
        $this->noteModel = new Note();
    }
    public function index(Request $request)
    {
        $criteria = (object) [
            'title' => $request->title,
            'published' => $request->published,
            'projectName' => $request->projectName
        ];
        $notes = $this->noteModel->getPublishedNotes($criteria);
        return view('viewnotes', ['notes' => $notes, 'criteria' => $criteria]);
    }
    /**
     * Funtion to open add note form.
     *
     * @return void
     */
    public function addNote($token = '')
    {
        $noteDetails = (object)[
            'id' => '',
            'title' => '',
            'published' => '',
            'description' => '',
            'projectid' => ''
        ];
        $projects = $this->projectModel->getPublishedProjects();
        if ($token == '') {
            return view('addnote', ['projects' => $projects, 'noteDetails' => $noteDetails, 'btn' => 'Submit']);
        }
        $noteDetails = $this->noteModel->getNoteByID($token);
        return view('addnote', ['projects' => $projects, 'noteDetails' => $noteDetails, 'btn' => 'Update']);
    }
    /**
     * Function to save note.
     *
     * @param  object $request
     * @return json
     */
    public function saveNote(Request $request)
    {
        try {
            $token = $request->token;
            if ($token == '') {
                $noteSave = $this->noteModel->noteSave($request);
                if ($noteSave) {
                    return showMessage(['status' => 'Saved successfully', 'messageClass' => 'alert-success', 'type' => 'success']);
                } else {
                    return showMessage(['status' => 'Error while saving.', 'messageClass' => 'alert-danger', 'type' => 'error']);
                }
            } else {
                $noteUpdate = $this->noteModel->noteUpdate($request);
                if ($noteUpdate) {
                    return showMessage(['status' => 'Updated successfully', 'messageClass' => 'alert-success', 'type' => 'success']);
                } else {
                    return showMessage(['status' => 'Error while saving.', 'messageClass' => 'alert-danger', 'type' => 'error']);
                }
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * Function to edit Note.
     *
     * @param  object $request
     * @return void
     */
    public function edit(Request $request)
    {
        try {
            $noteID = $request->id;
            if ($noteID == '') {
                return redirect()->to('/note');
            }
            return $this->addNote($noteID);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function deleteNote(Request $request)
    {
        try {            
            $noteID = $request->noteID;
            $note = Note::find($noteID);
            $note->delete();
            return showMessage(['status' => 'Deleted successfully', 'messageClass' => 'alert-success', 'type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
