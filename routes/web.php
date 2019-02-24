<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->post('auth/login', [
    'uses' => 'AuthController@authenticate'
]);
$router->group(['middleware' => 'auth:api', 'prefix' => 'checklists'], function () use ($router){
    //CHECKLISTS
    $router->get('/', 'ChecklistController@allChecklist');
    $router->get('/{checklistId}', 'ChecklistController@showChecklist');
    $router->post('/', 'ChecklistController@storeChecklist');
    $router->delete('/{checklistId}', 'ChecklistController@destroyChecklist');
    $router->patch('/{checklistId}', 'ChecklistController@updateChecklist');

    //ITEMS
    $router->post('/{checklistId}/items', 'ChecklistController@storeItem');
    $router->patch('/{checklistId}/items/{itemId}', 'ChecklistController@updateItem');
    $router->delete('/{checklistId}/items/{itemId}', 'ChecklistController@destroyItem');
    $router->get('/{checklistId}/items/{itemId}', 'ChecklistController@showItem');
    $router->get('/{checklistId}/items', 'ChecklistController@allItems');
    $router->post('/complete', 'ChecklistController@itemsComplete');
    $router->post('/incomplete', 'ChecklistController@itemsIncomplete');

    //TEMPLATES
    $router->post('/templates', 'ChecklistController@storeTemplate');
    $router->patch('/templates/{templateId}', 'ChecklistController@updateTemplate');
    $router->delete('/templates/{templateId}', 'ChecklistController@destroyTemplate');
    $router->get('/templates/{templateId}', 'ChecklistController@showTemplate');
});