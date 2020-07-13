<?php

namespace App\Http\Controllers;

use App\Models\Suggest;
use Illuminate\Http\Request;

class SuggestController extends Controller
{
    public function index()
    {
        $suggests = Suggest::paginate(config('paginates.pagination'));

        return view('admin.suggest_management.show_suggest', compact('suggests'));
    }

    public function create()
    {
        return view('client.contact-us');
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $data['user_id'] = auth()->user()->id;
            $data['status'] = config('status.pending');
            Suggest::create($data);
        }

        return response()->json(['result' => trans('client.send_suggest_success')]);
    }

    public function update(Request $request, $id)
    {
        $suggest = Suggest::findOrFail($id);

        if ($request->ajax()) {
            if ($suggest->status == config('status.pending')) {
                $suggest->update(['status' => config('status.approved')]);
            } elseif ($suggest->status == config('status.approved')) {
                $suggest->update(['status' => config('status.pending')]);
            }
        }
    }

    public function destroy($id)
    {
        $suggest = Suggest::findOrFail($id);
        $suggest->delete();

        return redirect()->route('suggests.index')->with('success', trans('message.deleted'));
    }
}
