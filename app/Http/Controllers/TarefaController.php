<?php

namespace App\Http\Controllers;

use App\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TarefaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tarefas = Tarefa::get();
        foreach ($tarefas as $tarefaKey => $tarefaValue) {
            $arquivoList = [];
            $arquivos = explode(',', $tarefaValue['arquivos']);
            foreach ($arquivos as $arquivo) {
                if (!empty($arquivo)) {
                    $arquivoList[] = asset('storage/' . $arquivo);
                }
            }
            $tarefas[$tarefaKey]['arquivos'] = $arquivoList;
        }
        return response()->json($tarefas, 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'titulo' => 'required',
            'descricao' => 'required',
            'status' => 'required',
            'arquivos.*' => 'required|file|mimes:jpg,png,pdf'
        ]);

        if (!$validator->fails()) {


            $titulo = $request->input('titulo');
            $descricao = $request->input('descricao');
            $status = $request->input('status');
            $files = $request->file('arquivos');

            $fileData = [];

            if ($files && is_array($files)) {
                foreach ($files as $file) {

                    $file = $file->store('public');
                    $url = explode('/', $file);
                    $fileData[] = end($url);
                }
            }
            $tarefa = Tarefa::create([
                'titulo' => $titulo,
                'descricao' => $descricao,
                'status' => $status,
                'arquivos' => implode(',', $fileData)
            ]);
            return response()->json($tarefa, 200);
        }
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
        $validator = Validator::make($request->all(), [
            'titulo' => 'required',
            'descricao' => 'required',
            'status' => 'required',
            'arquivos.*' => 'required|file|mimes:jpg,png,pdf'
        ]);

        if (!$validator->fails()) {

            $array = ['error' => ''];


            $titulo = $request->input('titulo');
            $descricao = $request->input('descricao');
            $status = $request->input('status');
            $list = $request->file('arquivos');



            if ($status && in_array($status, ['PENDENTE', 'ATIVO', 'FEITO'])) {

                $tarefa = Tarefa::find($id);
                if ($tarefa) {
                    if ($list && is_array($list)) {
                        if ($tarefa->arquivos) {
                            $files = explode(',', $tarefa->arquivos);
                            $this->removeFile($files);
                        }
                        foreach ($list as $file) {
                            if (!empty($file)) {
                                $file = $file->store('public');
                                $url = explode('/', $file);
                                $arquivos[] = end($url);
                                $tarefa->arquivos = implode(',', $arquivos);
                            }
                        }
                    }

                    $tarefa->status = $status;
                    $tarefa->titulo = $titulo;
                    $tarefa->descricao = $descricao;
                    $tarefa->save();
                    return response()->json($tarefa, 200);
                } else {
                    $array['error'] = 'tarefa inexistente';
                    return $array;
                }
            } else {
                $array['error'] = 'Statu não existe';
                return $array;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tarefa = Tarefa::where('id', $id)->first();
        if ($tarefa) {
            $tarefa->delete();
        } else {
            $array['error'] = 'tarefa inexistente';
            return $array;
        }
        return response()->json($tarefa, 200);
    }
    public function destroyPermanently($id)
    {
        $tarefa = Tarefa::where('id', $id)->withTrashed()->first();
        if ($tarefa) {
            if ($tarefa->arquivos) {
                $files = explode(',', $tarefa->arquivos);
                $this->removeFile($files);
            }
            $tarefa->forceDelete();
        } else {
            $array['error'] = 'tarefa inexistente';
            return $array;
        }
        return response()->json($tarefa, 200);
    }

    public function removeFile(array $arquivos)
    {
        $array = ['error' => ''];
        if ($arquivos && is_array($arquivos)) {
            foreach ($arquivos as $arquivo) {
                if (!empty($arquivo)) {
                    unlink(public_path('storage/' . $arquivo));
                }
            }
        }
        return $array;
    }
}
