<?php

namespace App\Http\Controllers;

use App\Repositories\Suggest\SuggestRepositoryInterface;
use Illuminate\Http\Request;

class SuggestController extends Controller
{
    protected $suggestRepo;

    public function __construct(SuggestRepositoryInterface $suggestRepo)
    {
        $this->suggestRepo = $suggestRepo;
    }

    public function index()
    {
        $suggests = $this->suggestRepo->showList(
            'id',
            'DESC',
            config('paginates.pagination')
        );

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
            $this->suggestRepo->create($data);
        }

        return response()->json(['result' => trans('client.send_suggest_success')]);
    }

    public function update(Request $request, $id)
    {
        $suggest = $this->suggestRepo->getById($id);

        if ($request->all()) {
            if ($suggest->status == config('status.pending')) {
                $this->suggestRepo->update($id, ['status' => config('status.approved')]);

                return true;
            } elseif ($suggest->status == config('status.approved')) {
                $this->suggestRepo->update($id, ['status' => config('status.pending')]);

                return true;
            }
        }

        return false;
    }

    public function destroy($id)
    {
        $this->suggestRepo->delete($id);

        return redirect()->route('suggests.index')->with('success', trans('message.deleted'));
    }
}
