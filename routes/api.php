<?php

use App\Http\Controllers\TarefaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/tarefas',[TarefaController::class, 'index']);
Route::post('/tarefas',[TarefaController::class, 'store']);
Route::post('/tarefa/{tarefaId}',[TarefaController::class, 'update']);
Route::delete('/tarefa/{tarefaId}',[TarefaController::class, 'destroy']);
Route::delete('/tarefa/deletar/{tarefaId}',[TarefaController::class, 'destroyPermanently']);