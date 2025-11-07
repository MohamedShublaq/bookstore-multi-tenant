<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAddress;
use App\Traits\DataTableTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use DataTableTrait;

    public function index()
    {
        return view('Library.Users.index');
    }

    public function getUsers(Request $request)
    {
        $query = User::latest();

        $result = $this->applyDataTable(
            $request,
            $query,
            ['first_name','last_name','email','phone']
        );

        $result['data'] = $result['data']->map(function ($user) {
            $user->actions = '
                <div class="dropdown">
                    <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="actionsMenu' . $user->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </button>
                    <div class="dropdown-menu" aria-labelledby="actionsMenu' . $user->id . '">
                        <a class="dropdown-item" href="' . route('library.users.show', $user->id) . '">
                            <i class="la la-eye"></i> Addresses
                        </a>
                        <hr/>
                        <button class="dropdown-item text-danger btn-delete" data-url="' . route('library.users.destroy', $user->id) . '">
                            <i class="la la-trash"></i> Delete
                        </button>
                    </div>
                </div>
            ';

            return $user;
        });

        return response()->json($result);
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('Library.Users.addresses', compact('id'));
    }

    public function getAddresses(Request $request)
    {
        $user = User::findOrFail($request->query('userId'));
        $query = UserAddress::where('user_id', $user->id)->latest();

        return $this->applyDataTable(
            $request,
            $query,
            ['address']
        );
    }

    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->back()->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }
}
