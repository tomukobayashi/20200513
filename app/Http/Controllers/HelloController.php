<?php

//コントローラークラスを作成する基本設定
//コントローラーの場所を指定
namespace App\Http\Controllers;

//下記の場所にあるRequestファイルを使える状態にしている
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// use App\Http\Requests\HelloRequest;
// use Validator;

use Illuminate\Support\Facades\DB;

class HelloController extends Controller
{
    public function index(Request $request)
    {
       $items = DB::table('people')->get();
       return view('hello.index', ['items' => $items]);
    }

   public function post(Request $request)
   {
       $items = DB::select('select * from people');
       return view('hello.index', ['items' => $items]);
   }


   // insert
   public function add(Request $request)
   {
       return view('hello.add');
   }

   public function create(Request $request)
   {
       $param = [
           'name' => $request->name,
           'mail' => $request->mail,
           'age' => $request->age,
       ];
       DB::insert('insert into people (name, mail, age) values (:name, :mail, :age)', $param);
       return redirect('/hello');
   }


   // update
   public function edit(Request $request)
{
   $param = ['id' => $request->id];
   $item = DB::select('select * from people where id = :id', $param);
   return view('hello.edit', ['form' => $item[0]]);
}

public function update(Request $request)
{
   $param = [
       'id' => $request->id,
       'name' => $request->name,
       'mail' => $request->mail,
       'age' => $request->age,
   ];
   DB::update('update people set name =:name, mail = :mail, age = :age where id = :id', $param);
   return redirect('/hello');
}

//delete
public function del(Request $request)
{
   $param = ['id' => $request->id];
   $item = DB::select('select * from people where id = :id', $param);
   return view('hello.del', ['form' => $item[0]]);
}

public function remove(Request $request)
{
   $param = ['id' => $request->id];
   DB::delete('delete from people where id = :id', $param);
   return redirect('/hello');
}

//show
public function show(Request $request)
{
    $items = DB::table('people')->orderBy('Age', 'asc')->get();
    return view('hello.index', ['items' => $items]);
}

}
