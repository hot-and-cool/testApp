<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo; // app/Todo.phpを使用可能にする

class TodoController extends Controller
{

    private $todo; //このクラス内でしか使えない変数

    public function __construct(Todo $instanceClass) //マジックメソッド：インスタンス化されるときに自動的に呼ばれる関数
    {
        $this->todo = $instanceClass; //今いるクラスの$todoにTodoクラスがインスタンスした際の値を代入
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = $this->todo->all(); //テーブルの値を全件取得
        return view('todo.index', compact('todos')); //todoディレクトリのindex.blade.phpファイルにtodosを渡す。→ビューファイルで変数が使える
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //DBに値を格納するための処理
    { //Request $requestでformタグで送信したPOST情報を受け取れる
        $input = $request->all(); //POSTで受け取った値全件取得
        //dd($input); デバッグ inputの中身を確認
        $this->todo->fill($input)->save(); //fill：引数を設定できるか確認 saveメソッドで値を保存
        return redirect()->to('todo'); //一覧画面に遷移
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $todo = $this->todo->find($id);
        return view('todo.edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $this->todo->find($id)->fill($input)->save(); //findでパラメーターのidを取得し、fillで確認し、保存
        return redirect()->to('todo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->todo->find($id)->delete(); //findでパラメーターのidを取得し、DBから削除する
        return redirect()->to('todo');
    }
}

