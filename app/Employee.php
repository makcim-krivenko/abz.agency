<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Employee extends Model
{
    /**
     * Folder with avatars
     *
     * @var string
     */
    const AVATAR_PATH = 'avatars/';

    /**
     * Folder with avatars
     *
     * @var string
     */
    const DEFAULT_AVATAR = 'default.jpg';


    /**
     * Boss name for current employee
     *
     * @var string
     */
    public $boss_name = 'This is the boss';

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = ['parent_id' => 1];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'position_id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'position_id',
        'full_name',
        'work_from',
        'work_to',
        'salary'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get related Position model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Formation of the path to the avatar
     *
     * @return string
     */
    public function avatarPath()
    {
        $path = static::AVATAR_PATH . $this->id . '.jpg';
        if (!Storage::exists($path)) {
            $path = static::AVATAR_PATH . static::DEFAULT_AVATAR;
        }

        return '/' . $path;
    }

    public function boss()
    {
        $boss = Employee::find($this->parent_id);
        if (isset($boss->id)) {
            $this->boss_name = $boss->full_name;
        }

        return $this->boss_name;
    }
}
