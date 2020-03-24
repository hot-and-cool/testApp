<?php
//Todoモデル

namespace App;
//今いる階層を名前空間Appと定義

use Illuminate\Database\Eloquent\Model;
// Modelクラスを使用可能にする

class Todo extends Model //Modelクラスを継承したTodoクラス
{
    protected $fillable = ['title']; //配列の値titleを変数に代入
}
