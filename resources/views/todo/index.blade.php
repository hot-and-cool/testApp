@extends ('layouts.app')
@section ('content')
<!-- app.blade.phpのyield内に接続 -->
<h1 class="page-header">ToDo一覧</h1>
<p class="text-right">
  <a class="btn btn-success" href="/todo/create">ToDoを追加</a>
</p>
<table class="table">
  <thead class="thead-light">
    <tr>
      <th>やること</th>
      <th>作成日時</th>
      <th>更新日時</th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach ($todos as $todo)
      <tr> <!-- variable(変数)->カラム名でそのカラムの値を取得できる。アロー演算子を使う理由はall()で取得した値はcollectionインスタンスで取得されるため -->
      <!-- 波括弧2つは変数をエスケープ タグとかを文字として出力する=  クロスサイトスクリプティング対策 htmlspecialchars関数を呼んでくれる-->
        <td class="align-middle">{{ $todo->title }}</td>
        <td class="align-middle">{{ $todo->created_at }}</td>
        <td class="align-middle">{{ $todo->updated_at }}</td>
        <td><a class="btn btn-primary" href="{{route('todo.edit', $todo->id) }}">編集</a></td> <!-- routeメソッドでurlを取得し$todo->idで対象のtodoのidカラムを持ったeditファイルへ遷移 -->
        <td>
            <!-- !!は変数を(タグなど)エスケープせずに出力。つまりタグを出力 -->
          {!! Form::open(['route' => ['todo.destroy', $todo->id], 'method' => 'DELETE']) !!} <!-- CSRF対策でnameにtokenを持ったinputタグが生成される  -->
          <!-- 引数は配列のみ。['route' => 'ルーティングのname' ]で飛ばす先を指定-->
            {!! Form::submit('削除', ['class' => 'btn btn-danger']) !!}
          {!! Form::close() !!}
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection