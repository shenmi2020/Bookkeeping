<?php

namespace app\model;

use support\Model;

class Account extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'account';

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
    protected $visible = ['id', 'name'];

    public function records()
    {
        return $this->hasMany('app\model\Record', 'aid', 'id');
    }
 
}