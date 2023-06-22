<?php

namespace App\Http\Controllers;

use App\Helpers\MessageHelper;
use App\Http\Requests\ColorRequest;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{

    private const ENTITY = 'Color';

    public function index(Request $request, Color $color = null)
    {

        $colors = Color::latest()->paginate(5);

        return view('admin.pages.color.index', compact('colors', 'color'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function store(ColorRequest $request)
    {
        Color::create($request->all());

        return redirect()->route('admin.colors.index')
            ->with('success', MessageHelper::createdSuccessMessage(self::ENTITY));
    }

    public function update(ColorRequest $request, Color $color)
    {
        $color->update($request->all());

        return redirect()->route('admin.colors.index')
            ->with('success', MessageHelper::updatedSuccessMessage(self::ENTITY));
    }

    public function destroy(Color $color)
    {
        $color->delete();

        return redirect()->route('admin.colors.index')
            ->with('success', MessageHelper::deletedSuccessMessage(self::ENTITY));
    }
}
