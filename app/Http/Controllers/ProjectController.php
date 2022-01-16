<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Session;

class ProjectController extends Controller
{
    protected $projectModel;
    public function __construct()
    {
        $this->projectModel = new Project();
    }
    public function index(Request $request)
    {
        $criteria = (object)[
            'projectname' => $request->projectName,
            'published' => $request->publishedStatus
        ];
        $projects = $this->projectModel->getProjects($criteria);
        return view('/viewprojects', ['projects' => $projects, 'criteria' => $criteria]);
    }    
    /**
     * Function to save project
     *
     * @param  mixed $request
     * @return void
     */
    public function save(Request $request)
    {
        $projectExists = $this->projectModel->projectExists($request);
        if (count($projectExists) > 0) {
            return response()->json(['type' => 'error', 'message' => 'Project already exists.']);
        }
        if ($request->token == '') {
            $projectSave =  $this->projectModel->projectSave($request);
            if ($projectSave) {
                return showMessage(['status' => 'Saved successfully', 'messageClass' => 'alert-success', 'type' => 'success']);
            } else {
                return showMessage(['status' => 'Error while saving.', 'messageClass' => 'alert-danger', 'type' => 'error']);
            }
        } else {
            $projectUpdate = $this->projectModel->projectUpdate($request);
            if ($projectUpdate) {
                return showMessage(['status' => 'Updated successfully', 'messageClass' => 'alert-success', 'type' => 'success']);
            } else {
                return showMessage(['status' => 'Error while saving.', 'messageClass' => 'alert-danger', 'type' => 'error']);
            }
        }
    }
    
    /**
     * Function to get project form modal.
     *
     * @param  mixed $request
     * @return void
     */
    public function getProjectForm(Request $request)
    {
        $projectID = $request->token;
        $projectDetail = (object) [
            'id' => '',
            'projectname' => '',
            'published' => ''
        ];
        if ($projectID == '') {
            return view('projectform', ['projectDetail' => $projectDetail, 'btn' => 'Submit']);
        }
        $projectDetail = Project::find($projectID);
        return view('projectform', ['projectDetail' => $projectDetail, 'btn' => 'Update']);
    }    
    /**
     * Function to delete project.
     *
     * @param  mixed $request
     * @return void
     */
    public function deleteProject(Request $request)
    {
        $projectID = $request->projectID;
        $project = Project::find($projectID);
        $project->delete();
        return showMessage(['status' => 'Deleted successfully', 'messageClass' => 'alert-success', 'type' => 'success']);        
    }
}
