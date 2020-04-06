<?php
//Todoモデル 


namespace App;
//今いる階層を名前空間Appと定義

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// eloquentモデル(Modelクラス)を使用可能にする

class Todo extends Model //Modelクラスを継承したTodoクラス DBへの操作を可能にする
{   
    use SoftDeletes; //トレイトを持ってくる

    //fillable定義している理由
    protected $fillable = ['title','user_id']; //配列の値title(カラム)を変数に代入
    // titleカラムの値のみ受け付ける ホワイトリスト
    // ここで指定したカラムのみfillメソッドできる
    // guarededはブラックリストを設定

    protected $dates = ['deleted_at'];

    public function getByUserId($id)
    {
        return $this->where('user_id', $id)->get();
    }
}