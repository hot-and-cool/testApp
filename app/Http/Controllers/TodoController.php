<?php
// contoroller = modelからDBの値を取得してviewに受け渡す

namespace App\Http\Controllers; //ディレクトリ階層を教えてくれる
/**名前空間 クラスをディレクトリのような階層構造に分類できる
 * 今回だと当controllerまでのディレクトリパスで定義
 * Controllersディレクトリ以下のファイルに共通のnamespaceを記述することでそのファイルのクラスを使用可能。
 * また.phpにも同じ名前空間があるので実質その中のクラスが呼び出せる
 * クラスからインスタンス生成する際の同名がある場合の重複エラーを避ける
*/

use Illuminate\Http\Request; //Requestクラスを使用可能にする
use App\Todo; // app/Todo.php(モデル)のTodoクラスを使用可能にする
/**useを使うことで深い名前空間のクラスをエイリアス（別名）を使って短く記述できる
 * use App\Todo→一番階層が浅いクラスが使える
 * useでこのファイルで使うクラスを指定する
 */

class TodoController extends Controller
{

    private $todo; //このクラス内でしか使えない変数 $todo = '';の略。呼び出すときは$を取る

    public function __construct(Todo $instanceClass) //マジックメソッド：インスタンス化されるときに自動的に呼ばれる関数
    {
        // dd($instanceClass); //これでTodoクラスのプロパティが覗ける
        // ↓Construct Injection
        $this->todo = $instanceClass; //使用する外部のTodoオブジェクトを変数todoに代入
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * コメント 本来はメソッドの返り値を記述しジャンプで確認できるようにする
     */
    public function index()
    {
        $todos = $this->todo->all(); //テーブルの値を全件取得 todo=Todoクラス
        return view('todo.index', compact('todos')); //todoディレクトリのindex.blade.phpファイルにtodosを渡す。→ビューファイルで変数が使える
        // viewメソッド:
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todo.create'); //todoディレクトリのcreateファイルを呼ぶ ヘルパーメソッド
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request //コメント引数
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //DBに値を格納するための処理
    { //Request $requestでformタグで送信したPOST情報を受け取れる
        $input = $request->all(); //POSTで受け取った値全件取得
        // dd($input);
        //dd($input); デバッグ inputの中身を確認
        $this->todo->fill($input)->save(); //fill：引数を設定できるか確認 saveメソッドで値を保存
        // fillメソッドでモデルのfillableで指定したカラムのみを送るように確認（フィルターの役割）
        return redirect()->to('todo'); //一覧画面に遷移 引数はuri
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
        return redirect()->to('todo'); //調べる
    }
}