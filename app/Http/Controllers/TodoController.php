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
// eloquentとはテーブル上のレコードをオブジェクトに対応させ操作や指定をできるようにする

    private $todo; //このクラス内でしか使えない変数 $todo = '';の略。呼び出すときは$を取る

    // protected:定義したクラス内及びこれを継承したものに使えるアクセス修飾子
    // private:定義したクラス内のみアクセスできる
    public function __construct(Todo $instanceClass) //マジックメソッド：todoコントローラーがインスタンス化されるときに自動的に呼ばれる関数
    {
        // $instanceClasの中身はModelクラス+$fillable
        // dd($instanceClass); //これでTodoクラスのプロパティが覗ける
        // todoクラスが他のクラスに依存していると動作しないので↓の書き方にしている
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
        $todos = $this->todo->all(); // all()の返り値はコレクションクラス Todoクラスの中身を全件取得 配列で取得しない todo=Todoクラス
        // dd($todos); //collectionインスタンスの確認
        //Todoクラスの中身が確認できる。テーブルのカラムと値はoriginalに格納されている
        return view('todo.index', compact('todos')); //todoディレクトリのindex.blade.phpファイルにtodosを渡す。→ビューファイルで変数が使える
        // viewヘルパ(bladeのファイル名, 第二引数に渡したい値)
        // compactメソッド:値から配列を作成してくれる 複数値があるときに可読性がよい
        // compactを使わない場合キー（'ビューで使う変数名'）とバリュー（$ビューに渡す値）を用意してあげる
        // return view('todo.index', ['todos' => $todos]);
        // return view('todo.index')->with('todos', $todos);
        // with('ビューで使う変数名', $ビューに渡す値);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todo.create'); //todoディレクトリのcreateファイルを呼ぶ ヘルパーメソッド
    // viewヘルパ(bladeのファイル名, 第二引数に渡したい値)

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request //コメント引数
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //ユーザから送られたリクエスト  を格納するクラス
    { //Request $requestでformタグで送信したPOST情報を受け取れる
        $input = $request->all(); //POSTで受け取った値全件取得
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
    public function edit($id) //urlのidを取得
    { //urlの$idに対応したレコード取得
        $todo = $this->todo->find($id); //findの返り値は引数に$idを持ったtodoモデル（オブジェクト）（レコード取得）
        // dd($todo);
        return view('todo.edit', compact('todo')); //変数todoから配列を作成
        // viewヘルパ(bladeのファイル名, 第二引数に渡したい値)
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) //request:クライアントが送ったデータが格納されている
    {
        $input = $request->all(); //ビューのinputで渡ってきた値を配列で取得
        // dd($input);
        $this->todo->find($id)->fill($input)->save(); //findでパラメーターのidを取得し、fillで確認し、保存
        // fillで複数代入を防ぐ。 検証ツールなどでinputを故意的に増やされた時、他のカラムに値を入れないように fillで入力カラムを指定している
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
        return redirect()->to('todo'); // redirect('todo')と同じ 可読性をあげるためこの書き方
    }
}