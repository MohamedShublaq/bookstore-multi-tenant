<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LibraryRequest;
use App\Models\Library;
use App\Models\LibraryAdmin;
use App\Traits\DataTableTrait;
use App\Traits\ImageManagerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LibraryController extends Controller
{
    use DataTableTrait, ImageManagerTrait;

    public function index(Request $request)
    {
        return view('Admin.Libraries.index');
    }

    public function getLibraries(Request $request)
    {
        $query = Library::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $query->latest();

        $result = $this->applyDataTable(
            $request,
            $query,
            ['name', 'slug', 'address', 'phone', 'currency']
        );

        $result['data'] = $result['data']->map(function ($library) {
            $library->logo = $library->logo
                ? '<img src="' . asset($library->logo) . '" alt="logo" width="50" height="50">'
                : '<span class="badge badge-secondary">No Logo</span>';

            $status = $library->status;

            $library->status = $status
                ? '<span class="badge badge-success">Active</span>'
                : '<span class="badge badge-danger">Inactive</span>';

            $icon  = $status ? 'la la-pause' : 'la la-play';
            $label = $status ? 'Deactivate' : 'Activate';

            $library->actions = '
                <div class="dropdown">
                    <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="actionsMenu' . $library->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </button>
                    <div class="dropdown-menu" aria-labelledby="actionsMenu' . $library->id . '">
                        <a class="dropdown-item" href="' . route('dashboard.libraries.edit', $library->id) . '">
                            <i class="la la-edit"></i> Edit
                        </a>
                        <a class="dropdown-item" href="' . route('dashboard.libraries.showAllAdmins', $library->id) . '">
                            <i class="la la-user"></i> Admins
                        </a>
                        <button class="dropdown-item btn-status" data-url="' . route('dashboard.libraries.changeStatus', $library->id) . '">
                            <i class="' . $icon . '"></i> ' . $label . '
                        </button>
                        <hr/>
                        <button class="dropdown-item text-danger btn-delete" data-url="' . route('dashboard.libraries.destroy', $library->id) . '">
                            <i class="la la-trash"></i> Delete
                        </button>
                    </div>
                </div>
            ';

            return $library;
        });

        return response()->json($result);
    }

    public function create()
    {
        return view('Admin.Libraries.create');
    }

    public function store(LibraryRequest $request)
    {
        try {
            DB::beginTransaction();
            $library = Library::create($this->getLibraryData($request));
            LibraryAdmin::create([
                'library_id' => $library->id,
                'name'       => $request->admin_name,
                'email'      => $request->email,
                'password'   => '123456789',
                'is_manager' => 1,
            ]);
            if ($request->hasFile('logo')) {
                $this->storeImage($request, $library, 'logo');
            }
            DB::commit();
            return redirect()->route('dashboard.libraries.index')->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Operation Failed');
        }
    }

    public function edit(string $id)
    {
        $library      = Library::findOrFail($id);
        $libraryAdmin = $this->getLibraryAdmin($id);
        return view('Admin.Libraries.edit', compact('library', 'libraryAdmin'));
    }

    public function update(LibraryRequest $request, string $id)
    {
        try {
            $library = Library::findOrFail($id);
            DB::beginTransaction();
            $library->update($this->getLibraryData($request));
            if ($request->hasFile('logo')) {
                $this->deleteImage($library, 'logo');
                $this->storeImage($request, $library, 'logo');
            }
            $libraryAdmin = $this->getLibraryAdmin($id);
            if ($libraryAdmin) {
                $libraryAdmin->update([
                    'name'  => $request->admin_name,
                    'email' => $request->email,
                ]);
            }
            DB::commit();
            return redirect()->route('dashboard.libraries.index')->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Operation Failed');
        }
    }

    public function destroy(string $id)
    {
        try {
            $library = Library::findOrFail($id);
            $this->deleteImage($library, 'logo');
            $library->delete();
            return redirect()->back()->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    public function showAllAdmins(string $libraryId)
    {
        return view('Admin.Libraries.admins', compact('libraryId'));
    }

    public function getAllAdmins(Request $request)
    {
        $query = LibraryAdmin::where('library_id', $request->libraryId)->oldest();

        $result = $this->applyDataTable(
            $request,
            $query,
            ['name', 'email']
        );

        $result['data'] = $result['data']->map(function ($admin) {
            $role = $admin->is_manager;

            $admin->role = $role
                ? '<span class="badge badge-success">Super Admin</span>'
                : '<span class="badge badge-secondary">Admin</span>';

            $admin->actions = '
                <div class="dropdown">
                    <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="actionsMenu' . $admin->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </button>
                    <div class="dropdown-menu" aria-labelledby="actionsMenu' . $admin->id . '">
                        <button class="dropdown-item btn-reset" data-url="' . route('dashboard.libraries.resetAdminPassword', $admin->id) . '">
                            <i class="la la-key"></i> Reset password
                        </button>
                    </div>
                </div>
            ';

            return $admin;
        });

        return response()->json($result);
    }

    public function changeStatus(string $id)
    {
        try {
            $library = Library::findOrFail($id);
            $library->update([
                'status' => !$library->status
            ]);
            return redirect()->back()->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    public function resetAdminPassword(string $id)
    {
        try {
            $admin = LibraryAdmin::findOrFail($id);
            $admin->update([
                'password' => '123456789'
            ]);
            return redirect()->back()->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    private function getLibraryData($request)
    {
        return [
            'name'      => $request->library_name,
            'slug'      => $request->slug,
            'address'   => $request->address,
            'phone'     => $request->phone,
            'currency'  => $request->currency,
        ];
    }

    private function getLibraryAdmin($libraryId)
    {
        return LibraryAdmin::where('library_id', $libraryId)->where('is_manager', 1)->first();
    }
}
