<?php

namespace Newsio\Model;

class Category extends BaseModel
{
    protected $table = 'categories';

    protected $visible = ['id', 'name'];
}
