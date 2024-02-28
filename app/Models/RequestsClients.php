<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestsClients extends Model
{
    use HasFactory;

    public function submission(){
        return $this->hasOne(RequestsClientsSubmission::class , 'client', 'id');
    }

    public function status(){
        return $this->hasOne(RequestClientsStatus::class , 'client', 'id');
    }

    public function address(){
        return $this->hasOne(RequestsClientsAddress::class , 'client', 'id');
    }

    public function material(){
        return $this->hasOne(RequestsClientsMaterial::class, 'client', 'id')->with('file_last_version')->with('file_all_version');
    }

    public function document(){
        return $this->hasOne(RequestsClientsDocuments::class, 'client', 'id');
    }

    public function article(){
        return $this->hasMany(RequestsClientsMaterial::class, 'client', 'id')->with("submissions")->withCount('file_all_version')->with('status');
    }

    public function description(){
        return $this->hasOne(RequestsClientsDescription::class, 'client', 'id');
    }

    public function files(){
        return $this->hasMany(RequestsClientsFiles::class, 'clients', 'id');
    }

    public function notes(){
        return $this->hasMany(RequestsClientsNotes::class, 'client', 'id')->with('users');
    }
}