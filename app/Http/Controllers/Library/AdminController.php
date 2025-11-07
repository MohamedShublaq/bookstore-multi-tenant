<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Http\Requests\Library\AdminRequest;
use App\Models\LibraryAdmin;
use App\Traits\DataTableTrait;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use DataTableTrait;

    public function index()
    {
        return view('Library.Admins.index');
    }

    public function getAdmins(Request $request)
    {
        $currentAdmin = auth('library-admin')->user();
        $query = LibraryAdmin::where('id', '!=', $currentAdmin->id)->latest();

        $result = $this->applyDataTable(
            $request,
            $query,
            ['name', 'email']
        );

        $result['data'] = $result['data']->map(function ($admin) {
            $admin->actions = '
                <div class="dropdown">
                    <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="actionsMenu' . $admin->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </button>
                    <div class="dropdown-menu" aria-labelledby="actionsMenu' . $admin->id . '">
                        <a class="dropdown-item" href="' . route('library.admins.edit', $admin->id) . '">
                            <i class="la la-edit"></i> Edit
                        </a>
                        <button class="dropdown-item btn-reset" data-url="' . route('library.admins.resetPassword', $admin->id) . '">
                            <i class="la la-key"></i> Reset password
                        </button>
                        <hr/>
                        <button class="dropdown-item text-danger btn-delete" data-url="' . route('library.admins.destroy', $admin->id) . '">
                            <i class="la la-trash"></i> Delete
                        </button>
                    </div>
                </div>
            ';

            return $admin;
        });

        return response()->json($result);
    }

    public function create()
    {
        return view('Library.Admins.create');
    }

    public function store(AdminRequest $request)
    {
        try {
            $currentAdmin = auth('library-admin')->user();
            LibraryAdmin::create([
                'name'       => $request->name,
                'email'      => $request->email,
                'password'   => '123456789',
                'library_id' => $currentAdmin->library_id,
            ]);
            return redirect()->route('library.admins.index')->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    public function edit(string $id)
    {
        $admin = LibraryAdmin::findOrFail($id);
        return view('Library.Admins.edit', compact('admin'));
    }

    public function update(AdminRequest $request, string $id)
    {
        try {
            $admin = LibraryAdmin::findOrFail($id);
            $admin->update([
                'name'   => $request->name,
                'email'  => $request->email,
            ]);
            return redirect()->route('library.admins.index')->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    public function destroy(string $id)
    {
        try {
            $admin = LibraryAdmin::findOrFail($id);
            $admin->delete();
            return redirect()->back()->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    public function resetPassword(string $id)
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
}
