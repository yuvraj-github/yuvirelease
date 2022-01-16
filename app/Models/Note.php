<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use DB;

class Note extends Model
{
    use HasFactory;
    use Sortable;

    public $sortable = ['id', 'title', 'published', 'projects.projectname'];

    /**
     * Function to save note.
     *
     * @param  object $request
     * @return boolean
     */
    public function noteSave($request)
    {
        $note = new Note();
        $note->title = $request->title;
        $note->projectid = $request->project;
        $note->description = $request->description;
        $note->published = $request->published;
        if ($note->save()) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Function to get published notes
     *
     * @param  object $criteria
     * @return void
     */
    public function getPublishedNotes($criteria)
    {
        try {
            DB::enableQueryLog();
            $whereCondition = '1 AND ';
            $whereProjCond = '';
            if ($criteria->title != '') {
                $whereCondition .= "title LIKE '%$criteria->title%' AND ";
            }
            if ($criteria->published != '') {
                $whereCondition .= "notes.published = '$criteria->published' AND ";
            }
            if ($criteria->projectName != '') {
                $whereCondition .= "projectname LIKE '%$criteria->projectName%'";
            }
            $whereCondition = trim($whereCondition, " AND ");
            $notes = Note::with('project')
               ->whereHas('project', function ($query) use($whereCondition){
                    $query->whereRaw($whereCondition);
                })
                ->sortable()
                ->orderBy('notes.id', 'desc')
                ->paginate(20);
            $query = DB::getQueryLog();
            //dd($query);
            return $notes;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'projectid', 'id');
    }
    /**
     * Function to get note details
     *
     * @param  string $noteID
     * @return object
     */
    public function getNoteByID($noteID = '')
    {
        $noteDetails = Note::find($noteID);
        return $noteDetails;
    }
    /**
     * Function to update note.
     *
     * @param  object $request
     * @return boolean
     */
    public function noteUpdate($request)
    {
        $note = Note::find($request->token);
        $note->title = $request->title;
        $note->projectid = $request->project;
        $note->description = $request->description;
        $note->published = $request->published;
        $updateNote = $note->update();
        if ($updateNote) {
            return true;
        }
        return false;
    }
}
