<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\DataTables\UsersDataTable;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class UserController extends Controller
{
    protected $index = 'User';
    protected $indexRoute = 'users';
    protected $commonService;

    public function __construct(CommonService $commonService)
    {
        $this->commonService = $commonService;
    }

    public function index(Request $request, UsersDataTable $dataTable)
    {
        if ($request->ajax()) {
            return $this->commonService->jsonResponse(User::all(), "{$this->index} list fetched");
        }

        return $dataTable->render('common.index', [
            'title' => "{$this->index} " . trans('admin_fields.list'),
            'route' => $this->indexRoute,
            'index' => $this->index,
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $data['image'] = $this->commonService->uploadImage($request->file('image'), 'users');
            }

            if ($request->hasFile('icon')) {
                $data['icon'] = $this->commonService->uploadImage($request->file('icon'), 'users');
            }

            $item = User::create($data);
            DB::commit();

            if ($request->ajax()) {
                return $this->commonService->jsonResponse($item, "{$this->index} created", 201);
            }

            return redirect()->route($this->indexRoute . '.index')->with('success', "{$this->index} created");
        } catch (Throwable $th) {
            DB::rollBack();
            return $this->commonService->jsonResponse(null, $th->getMessage(), 500);
        }
    }

    public function show(User $item)
    {
        return response()->json($item);
    }

    public function edit(User $item)
    {
        return response()->json($item);
    }

    public function update(UpdateUserRequest $request, User $item)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $data['image'] = $this->commonService->uploadImage($request->file('image'), 'users');
            }

            if ($request->hasFile('icon')) {
                $data['icon'] = $this->commonService->uploadImage($request->file('icon'), 'users');
            }

            $item->update($data);
            DB::commit();

            if ($request->ajax()) {
                return $this->commonService->jsonResponse($item, "{$this->index} updated");
            }

            return redirect()->route($this->indexRoute . '.index')->with('success', "{$this->index} updated");
        } catch (Throwable $th) {
            DB::rollBack();
            return $this->commonService->jsonResponse(null, $th->getMessage(), 500);
        }
    }

    public function destroy(Request $request, User $item)
    {
        DB::beginTransaction();
        try {
            $item->delete();
            DB::commit();

            if ($request->ajax()) {
                return $this->commonService->jsonResponse(null, "{$this->index} deleted");
            }

            return redirect()->route($this->indexRoute . '.index')->with('success', "{$this->index} deleted");
        } catch (Throwable $th) {
            DB::rollBack();
            return $this->commonService->jsonResponse(null, $th->getMessage(), 500);
        }
    }

    public function status(Request $request)
    {
        return $this->commonService->toggleStatus($request, User::class);
    }
}
