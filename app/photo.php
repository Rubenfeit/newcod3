<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class photo extends Model
{
    protected $fillable = ['file'];

    protected $uploads = '/images/';

    public function getFileAttribute($photo){ //esta funçao faz parte do sistema, é por isso que no index nao precisamos de meter o caminho no src
        // <td>{{$user->id}}<td><img height="50" src="{{$user->photo ? $user->photo->file : 'no user photo'}}" alt=""></td>

        return $this->uploads.$photo;
    }
}


