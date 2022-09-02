<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\CompanyScope;

class Document extends Model
{
    //
    protected   $fillable=[ 'document', 'type_id', 'user_id', 'last_mod_id', 'expiry','company_id'];
    protected $dates= ['expiry','created_at','updated_at'];
    public  $realdocument;


  protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope);
    }

    public function user(){
    	return $this->belongsTo('App\User','user_id')->withDefault();
    }
    public function user_modified(){
    	return $this->belongsTo('App\User','last_mod_id')->withDefault();
    }

    public function folder(){
    	return $this->belongsTo('App\DocumentType','type_id')->withDefault();
    }

    public function getDocumentLinkAttribute(){

        $document=explode(';',$this->document);
        if(!isset($document[1])){
            return $this->document;
        }
        return $document[0];
    }

    public function getdocumentNameAttribute(){
      $ferma_doc= $this->decodeFermaDocument($this->document);
      if($ferma_doc){
          return $ferma_doc;
      }
        $name=explode('/', $this->document);
        return isset($name[2]) ? $name[2] : $this->document ;
    }

    public function decodeFermaDocument($document){

      $document=explode(';',$document);

      if(!isset($document[1])){
          return false;
      }
       return $document[1];
    }


}
