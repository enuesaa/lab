<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::top');
Route::livewire('/about', 'pages::about');
Route::livewire('/memo/create', 'pages::memos.create');
Route::livewire('/memos/{id}', 'pages::memos.view');
Route::livewire('/memos/{id}/update', 'pages::memos.update');
