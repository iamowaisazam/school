<?php
namespace App\Enums;

class Permission
{

CONST DATA = array(
       'dashboard' => [
         'list'
        ],
        'branches' => [
            'list',
            'create',
            'edit',
            'view',
            'delete',
        ],
        'students' => [
            'list',
            'create',
            'edit',
            'view',
            'delete',
        ],
    );

}