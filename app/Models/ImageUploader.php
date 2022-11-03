<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use File;
class ImageUploader extends Model
{
    use HasFactory;

    public static function upload($file,$destinationfolder){

        if (empty($file))

            return NULL;

        	$destinationPath = public_path().'/storage/'.$destinationfolder;

        	if(!File::isDirectory($destinationPath)){
		        File::makeDirectory($destinationPath, 0777, true, true);
		    }
			//Getting the Image Extension
            $ext = $file->getClientOriginalExtension();

            $file_url =\Str::random(12).'.'.$ext;

            $file->move($destinationPath,$file_url);

            return $file_url;
    }

}
