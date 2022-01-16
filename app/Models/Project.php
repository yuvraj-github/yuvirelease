<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use DB;


class Project extends Model
{
    use HasFactory;
    use Sortable;

    public $sortable = ['id', 'projectname', 'published'];
    
    /**
     * Function to get all projects.
     *
     * @param  object $criteria
     * @return object
     */
    public function getProjects($criteria)
    {
        //DB::enableQueryLog();
        $whereCondition = '1 AND ';
        if ($criteria->projectname != '') {
            $whereCondition .= "projectname LIKE '%$criteria->projectname%' AND ";
        }
        if ($criteria->published != '') {
            $whereCondition .= "published = '$criteria->published'";
        }
        $whereCondition = trim($whereCondition, " AND ");
        $projects =  Project::whereRaw($whereCondition)
            // ->orderBy('id', 'desc')
            ->sortable()
            ->orderBy('id', 'desc')
            ->paginate(20);
        //$query = DB::getQueryLog();
        //dd($query);
        return $projects;
    }    
    /**
     * Function to save project.
     *
     * @param  object $request
     * @return boolean
     */
    public function projectSave($request)
    {
        $project = new Project;
        $project->projectname = $request->projectName;
        $project->published = $request->published;
        if ($project->save()) {
            return true;
        } else {
            return false;
        }
    }    
    /**
     * Function to update project.
     *
     * @param  object $request
     * @return boolean
     */
    public function projectUpdate($request)
    {
        $project = Project::find($request->token);
        $project->projectname = $request->projectName;
        $project->published = $request->published;
        $update = $project->update();
        if ($update) {
            return true;
        } else {
            return false;
        }
    }    
    /**
     * Function to check project already exists.
     *
     * @param  object $request
     * @return object
     */
    public function projectExists($request)
    {
        $projectExists = Project::where('projectname', "$request->projectName")
                                ->where('id', '<>', $request->token)
                                ->get();
        return $projectExists;
    }    
    /**
     * Function to get published projects
     *
     * @return object
     */
    public function getPublishedProjects()
    {
        $projects = Project::where('published', '1')->orderBy('id', 'desc')->get();
        return $projects;
    }
}
