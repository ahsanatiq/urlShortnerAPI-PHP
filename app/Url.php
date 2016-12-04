<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{

    protected $fillable = [
        'desktop_url', 'mobile_url','tablet_url'
    ];

    protected static $rules = [
        'desktop_url'=>'required|url',
        'mobile_url'=>'url',
        'tablet_url'=>'url'
    ];

    public static function rules($context='create')
    {
        $rules = self::$rules;
        if($context=='update') {
            $rules['desktop_url'] = str_replace('required|', '', $rules['desktop_url']);
        }
        return $rules;
    }

}
