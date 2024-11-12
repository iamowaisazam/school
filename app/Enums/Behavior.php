<?php
namespace App\Enums;

class Behavior
{

    CONST DATA = [
      'social_behavior' => [
        ['id'=> 1,'name' => 'Organize belongings',''],
        ['id'=> 2,'name' => 'Keeping home clean'],
        ['id'=> 3,'name' => 'Helping in house chores'],
        ['id' =>4,'name' => 'Obedience'],
        ['id' =>5,'name' => 'Helping others'],
        ['id' =>6,'name' => 'Behavior with siblings/ cousins'],
        ['id' =>7,'name' => 'Behavior with parents'],
        ['id' =>8,'name' => 'Sharing'],
      ],
      'personal_habits' => [
        ['id'=>9,'name' => 'Taking meals properly'],
        ['id'=>10,'name' => 'Avoiding screen / media'],
        ['id'=>11,'name' => 'Nap / Qeloola (Y/N)'],
        ['id' =>12,'name' => 'Masnoon Duas'],
        ['id' =>13,'name' => 'Mention sleeping time'],
      ]
      ];


    static public function  cc($i) {
        return match ($i) {
          'e' => 1,
          'g' => 2,
          'r' => 3,
          'b' => 4,
          'n' => 5,
          default => 0,
      };
    }  


}