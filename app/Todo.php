<?php
//Todoモデル 


namespace App;
//今いる階層を名前空間Appと定義

use Illuminate\Database\Eloquent\Model;
// eloquentモデル(Modelクラス)を使用可能にする

class Todo extends Model //Modelクラスを継承したTodoクラス DBへの操作を可能にする
{   //fillable定義している理由
    protected $fillable = ['title']; //配列の値title(カラム)を変数に代入
    // titleカラムの値のみ受け付ける ホワイトリスト
    // ここで指定したカラムのみfillメソッドできる
    // guarededはブラックリストを設定
}