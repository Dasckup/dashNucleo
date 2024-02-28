<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentsEditorsReportUser extends Model
{
    use HasFactory;

    protected $table = 'comments_editors_report_user';

    public function editor()
    {
        return $this->belongsTo(Editors::class, 'id');
    }

    public function process()
    {
        return $this->belongsTo(ClientsProccess::class, 'id');
    }

    public function report()
    {
        return $this->belongsTo(OptionsUsersReports::class, 'id');
    }

    public function comment()
    {
        return $this->belongsTo(CommentsEditorsProccess::class, 'id');
    }

    public function author()
    {
        return $this->belongsTo(AuthorAccess::class, 'id');
    }
}
