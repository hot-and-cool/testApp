@extends ('layouts.app')
@section ('content')

<h2 class="mb-3">ToDo編集</h2>
<!-- POST:値の追加 PUTは値の更新(PATCHは指定したカラムなど一部分のみの更新) -->
{!! Form::open(['route' => ['todo.update', $todo->id], 'method' => 'PUT']) !!}
  <div class="form-group">
    {!! Form::input('text', 'title', $todo->title, ['required', 'class' => 'form-control']) !!}
  </div>
  {!! Form::submit('更新', ['class' => 'btn btn-success float-right']) !!}
{!! Form::close() !!}
@endsection