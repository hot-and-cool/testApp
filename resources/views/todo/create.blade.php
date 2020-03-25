@extends ('layouts.app')
@section ('content')
<h2 class="mb-3">ToDo作成</h2>
<!-- htmlファームを作成する -->
{!! Form::open(['route' => 'todo.store']) !!} <!-- methodはデフォルトでPOST routeのnameで遷移先を指定-->
  <div class="form-group">
      <!-- 入力フィールドを作成する 
        第一引数 type
        第二引数 name
        第三引数 value フィールド初期値
        第四引数 reqired(必須かどうか)やクラス等
        -->
    {!! Form::input('text', 'title', null, ['required', 'class' => 'form-control', 'placeholder' => 'ToDo内容']) !!}
  </div>
  <!-- 第一引数にvalue
        第二引数でクラス等 -->
  {!! Form::submit('追加', ['class' => 'btn btn-success float-right']) !!}
{!! Form::close() !!}
@endsection

