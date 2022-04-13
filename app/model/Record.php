<?php

namespace app\model;

use support\Model;

class Record extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'record';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    // protected $guarded  = [];
    
    protected $visible = ['id', 'day', 'type', 'money', 'remark', 'category_name'];

    // public function post()
    // {
    //     return $this->belongsTo('app\model\Category', 'category_id')->select('title');;
    // }
}