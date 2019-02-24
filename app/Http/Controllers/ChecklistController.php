<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Req;
use Unlu\Laravel\Api\QueryBuilder;
use Unlu\Laravel\Api\RequestCreator;
use App\Checklist;
use App\Item;
use App\Template;
use Auth;

class ChecklistController extends Controller
{
    /**
     * CHECKLISTS
     */

     public function storeChecklist(Request $request)
    {
        $this->validate($request, [
            'data.attributes.object_domain' => 'required',
            'data.attributes.object_id' => 'required',
            'data.attributes.description' => 'required',
        ]);

        $data = $request->data['attributes'];
        $checklist = Checklist::create([
            'object_domain' => $data['object_domain'],
            'object_id' => $data['object_id'],
            'description' => $data['description'],
            'due' => date("Y-m-d H:i:s", strtotime($data['due'])),
            'urgency' => $data['urgency']
        ]);

        $response = ['data' => ['type' => 'checklists', 'id' => $checklist->id, 'attributes' => Checklist::find($checklist->id), 'links' => ['self' => $request->fullUrl()]]];
        return response()->json($response);
    }

    public function destroyChecklist($checklistId)
    {
        Checklist::findOrFail($checklistId)->delete();
        return response('', 204);
    }

    public function updateChecklist(Request $request, $checklistId)
    {
        $data = $request->data['attributes'];

        Checklist::findOrFail($checklistId)->update([
            'object_domain' => $data['object_domain'],
            'object_id' => $data['object_id'],
            'description' => $data['description'],
            'is_completed' => $data['is_completed'],
            'completed_at' => $data['completed_at'],
            'created_at' => date("Y-m-d H:i:s", strtotime($data['created_at'])),
        ]);
        
        $response = ['data' => ['type' => 'checklists', 'id' => $checklistId, 'attributes' => Checklist::find($checklistId), 'links' => ['self' => $request->fullUrl()]]];
        return response()->json($response);
    }

    public function showChecklist($checklistId, Request $request)
    {
        Checklist::findOrFail($checklistId);
        $checklist = new QueryBuilder(new Checklist, $request);
        $response = ['data' => ['type' => 'checklists', 'id' => $checklistId, 'attributes' => $checklist->build()->get(), 'links' => ['self' => Req::fullUrl()]]];
        return response()->json($response);
    }

    public function allChecklist(Request $request)
    {
        $checklist = new QueryBuilder(new Checklist, $request);
        $checklists = $checklist->build()->paginate();
        $response = 
        [   'meta'  => ['count' => $checklists->count(),  'total' => $checklists->total() ], 
            'links' => ['first' => $checklists->url($checklists->firstItem()), 
                        'last' => $checklists->url($checklists->lastPage()), 
                        'next' => $checklists->nextPageUrl(), 
                        'previous' => $checklists->previousPageUrl()
                    ],
            'data'  => [
                    'type' => 'checklist',
                    'id' => 1,
                    'attributes' => $checklist->build()->get(),
                    'links' => ['self' => Req::fullUrl()]
            ]
        ];
        return response()->json($response);
    }

    /**
     * ITEMS
     */

    public function itemsComplete(Request $request)
    {
        $data = $request->data;
        $itemsIds = array_column($data, 'item_id');
        Item::whereIn('id', $itemsIds)->update(['completed_at' => date("Y-m-d H:i:s"), 'is_completed' => true]);

        return response()->json(['data' => Item::selectRaw('id,id as item_id, is_completed, checklist_id')->whereIn('id', $itemsIds)->get()]);
    }

    public function itemsIncomplete(Request $request)
    {
        $data = $request->data;
        $itemsIds = array_column($data, 'item_id');
        Item::whereIn('id', $itemsIds)->update(['completed_at' => null, 'is_completed' => false]);

        return response()->json(['data' => Item::selectRaw('id,id as item_id, is_completed, checklist_id')->whereIn('id', $itemsIds)->get()]);
    }

    public function storeItem(Request $request, $checklistId)
    {
        $this->validate($request, [
            'data.attribute.description' => 'required',
        ]);

        $data = $request->data['attribute'];
        
        $item = Item::create([
            'checklist_id' => $checklistId,
            'description' => $data['description'],
            'due' => $data['due'],
            'urgency' => $data['urgency'],
            'user_id' => Auth::user()->id
        ]);

        $responseData = ['data' => ['type' => 'items', 'id' => $checklistId, 'attributes' => Item::findOrFail($item->id), 'links' => ['self' => $request->fullUrl()]]];
        return response()->json($responseData);
    }

    public function updateItem(Request $request, $checklistId, $itemId)
    {
        $this->validate($request, [
            'data.attribute.description' => 'required',
        ]);

        $data = $request->data['attribute'];
        
        Item::whereChecklistId($checklistId)->findOrFail($itemId)->update([
            'description' => $data['description'],
            'due' => $data['due'],
            'urgency' => $data['urgency'],
            'updated_by' => Auth::user()->id
        ]);

        $responseData = ['data' => ['type' => 'items', 'id' => $checklistId, 'attributes' => Item::findOrFail($itemId), 'links' => ['self' => $request->fullUrl()]]];
        return response()->json($responseData);
    }

    public function destroyItem($checklistId, $itemId)
    {
        $item = Item::whereChecklistId($checklistId)->findOrFail($itemId);
        $item->delete();
        return response()->json(['data' => ['type' => 'items', 'id' => $itemId, 'attributes' => $item, 'links' => ['self' => Req::fullUrl()]]]);
    }

    public function showItem($checklistId, $itemId)
    {
        $item = Item::whereChecklistId($checklistId)->findOrFail($itemId);
        return response()->json(['data' => ['type' => 'items', 'id' => $itemId, 'attributes' => $item, 'links' => ['self' => Req::fullUrl()]]]);
    }

    public function allItems(Request $request, $checklistId)
    {
        $checklist = Checklist::findOrFail($checklistId);

        $request = $request->all();
        $request['checklist_id'] = $checklistId;
        $request = RequestCreator::createWithParameters($request);

        $item = new QueryBuilder(new Item, $request);
        $items = $item->build()->paginate();

        $attributes = $checklist->first();
        $attributes['items'] = $item->build()->get();
        
        $response = 
        [   'meta'  => ['count' => $items->count(),  'total' => $items->total() ], 
            'links' => ['first' => $items->url($items->firstItem()), 
                        'last' => $items->url($items->lastPage()), 
                        'next' => $items->nextPageUrl(), 
                        'previous' => $items->previousPageUrl()
                    ],
            'data'  => [
                    'type' => 'checklist',
                    'id' => 1,
                    'attributes' => $attributes,
                    'links' => ['self' => Req::fullUrl()]
            ]
        ];
        return response()->json($response);
    }

    /**
     * TEMPLATES
     */
    
    public function storeTemplate(Request $request)
    {
        $this->validate($request, [
            'data.attributes.name' => 'required',
        ]);

        $data = $request->data['attributes'];
        
        $template = Template::create([
            'name' => $data['name'],
        ]);

        $checklist = Checklist::create([
            'template_id' => $template->id,
            'description' => $data['checklist']['description'],
            'due' => addTime($data['checklist']['due_interval'], $data['checklist']['due_unit']),
            'due_interval' => $data['checklist']['due_interval'],
            'due_unit' => $data['checklist']['due_unit']
        ]);

        foreach ($data['items'] as $item) {
            Item::create([
                'checklist_id' => $checklist->id,
                'user_id' => Auth::user()->id,
                'description' => $item['description'],
                'urgency' => $item['urgency'],
                'due' => addTime($item['due_interval'], $item['due_unit']),
                'due_interval' => $item['due_interval'],
                'due_unit' => $item['due_unit']
            ]);
        }

        $responseData = ['data' => ['id' => $template->id, 'attributes' => $data, 'links' => ['self' => $request->fullUrl()]]];
        return response()->json($responseData);
    }

    public function updateTemplate(Request $request, $templateId)
    {
        $this->validate($request, [
            'data.attributes.name' => 'required',
        ]);

        $data = $request->data['attributes'];
        
        $template = Template::findOrFail($templateId)->update([
            'name' => $data['name'],
        ]);

        $checklist = Checklist::whereTemplateId($templateId);

        $checklist->update([
            'description' => $data['checklist']['description'],
            'due' => addTime($data['checklist']['due_interval'], $data['checklist']['due_unit']),
            'due_interval' => $data['checklist']['due_interval'],
            'due_unit' => $data['checklist']['due_unit']
        ]);

        foreach ($data['items'] as $item) {
            Item::whereChecklistId($checklist->first()->id)->update([
                'updated_by' => Auth::user()->id,
                'description' => $item['description'],
                'urgency' => $item['urgency'],
                'due' => addTime($item['due_interval'], $item['due_unit']),
                'due_interval' => $item['due_interval'],
                'due_unit' => $item['due_unit']
            ]);
        }

        $responseData = ['data' => ['id' => $templateId, 'attributes' => $data, 'links' => ['self' => $request->fullUrl()]]];
        return response()->json($responseData);
    }

    public function destroyTemplate($templateId)
    {
        $temp = Template::findOrFail($templateId);
        $temp->delete();
    }

    public function showTemplate($templateId)
    {
        $template = Template::with('checklist.items:checklist_id,id,urgency,due_unit,due_interval')->find($templateId);
        $a = $template->checklist['items'];
        $checklist = unset($a['items']);
        $response = [
            'data' => [
                'type' => 'templates', 
                'id' => $templateId, 
                'attributes' => [
                    'name' => $template->name,
                    'items' => $template->checklist->items,
                    'checklist' => $checklist
                ],
                'links' => ['self' => Req::fullUrl()]
            ]
        ];
        return $response;
    }
}
