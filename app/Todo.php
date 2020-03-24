<?php
//Todoモデル

namespace App;
//今いる階層を名前空間Appと定義

use Illuminate\Database\Eloquent\Model;
// Modelクラスを使用可能にする

class Todo extends Model //Modelクラスを継承したTodoクラス DBへの操作を可能にする
{   //fillable定義している理由
    protected $fillable = ['title']; //配列の値title(カラム)を変数に代入
    // $fillable 複数代入時に許可するカラムを指定
    // $guarded 複数代入時に許可しないカラムを指定
}