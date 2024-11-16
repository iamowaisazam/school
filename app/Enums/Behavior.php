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
      ],
      'personal_habits2' => [
        ['id'=>9,'name' => 'Taking meals properly'],
        ['id'=>10,'name' => 'Avoiding screen / media'],
        ['id'=>11,'name' => 'Nap / Qeloola (Y/N)'],
        ['id' =>12,'name' => 'Masnoon Duas'],
        ['id' =>13,'name' => 'Namaz'],
        ['id' =>14,'name' => 'Miswak before prayer'],
        ['id' =>15,'name' => 'Surah Mulk & Yaseen (Y/N)'],
        ['id' =>16,'name' => 'Mention sleeping time'],
        ['id' =>17,'name' => 'Selected act of kindness'],
      ]
  ];


    static public function  cc($i) {
          if (strtolower($i) === 'e') {
            return 5;
        } elseif (strtolower($i) === 'g') {
            return 4;
        } elseif (strtolower($i) === 'r') {
            return 3;
        } elseif (strtolower($i) === 'b') {
            return 2;
        } elseif (strtolower($i) === 'n') {
            return 1;
        } else {
            return 0;
        }

    }  


}