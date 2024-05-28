<?php

namespace App\Http\Controllers;

use App\Models\CustomPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomPageController extends Controller
{
    public function getCustomPages(Request $request) 
    {
        $customPages = CustomPage::all();

        if ($customPages)
        {
            return response()->json([
                'pages' => $customPages,
            ], 200);
        }
        return response()->json([
            'message' => 'Not found'
        ], 404);
    }

    public function getCustomPage(Request $request, string $name)
    {
        $customPage = CustomPage::query()->where('pageName', $name)->first();

        if ($customPage)
        {
            return response()->json([
                'page' => $customPage,
            ], 200);
        }
        return response()->json([
            'message' => 'Not found'
        ], 404);
    }

    public function createCustomPage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pageName' => 'required|max:24',
            'content' => 'required|max:10000'
        ]);
        if ($validator->fails()) 
        {
            return response()->json([
                'message' => 'validation error',
                'erroes' => $validator->errors()
            ], 422);
        }
        $customPage = new CustomPage();
        $customPage->pageName = $request->post('pageName');
        $customPage->content = $request->post('content');

        $customPage->save();

        return response()->json([
            'message' => 'Sponsor created',
            'customPage' => $customPage
        ], 201);
    }

    public function updatePage(Request $request, int $id) {
        $validator = Validator::make($request->all(), [
            'content' => 'required|max:10000',
            'pageName' => 'required|max:24'
        ]);
        
        if ($validator->fails()) 
        {
            return response()->json([
                'message' => 'validation error',
                'erroes' => $validator->errors()
            ], 422);
        }

        $customPage = CustomPage::query()->find($id);


        if ($customPage)
        {
            $customPage->content = $request->input('content');
            $customPage->pageName = $request->input('pageName');
            $customPage->update();

            return response()->json([
                'message' => 'Sponsor updated correctly',
                'customPage' => $customPage,
            ], 201);
        }

        return response()->json(['message' => 'Page not found'], 404);

    }

    public function deletePage(int $id)
    {
        $customPage = CustomPage::query()->find($id);

        if ($customPage) 
        {
            $customPage->delete();
            return response()->json(['message' => 'Page deleted'], 204);
        }
        return response()->json(['message' => 'Page not found'], 404);
    }
}
