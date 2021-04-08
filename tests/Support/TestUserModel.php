<?php

namespace Captenmasin\LaravelViewWith\Tests\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TestUserModel extends Model
{
    use HasFactory;

    protected $table = 'test_user_models';

    protected $guarded = [];

    public $timestamps = false;
}
