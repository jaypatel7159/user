<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
{
    return view('users.index');
}

public function getUsers(Request $request)
{
    $users = User::with(['country', 'state', 'city'])->paginate(10); // Adjust pagination as needed
    return response()->json($users);
}

public function store(Request $request)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $request->user_id,
        'gender' => 'required|string',
        'country' => 'required|string',
        'state' => 'required|string',
        'city' => 'required|string',
        'technologies' => 'required|array',
        'image' => 'nullable|image|max:2048',
    ]);

    $user = $request->user_id ? User::findOrFail($request->user_id) : new User;
    $user->fill($request->except('image'));

    if ($request->hasFile('image')) {
        $user->image = $request->file('image')->store('images', 'public');
    }

    $user->save();

    return response()->json(['success' => 'User saved successfully.']);
}

public function show($id)
{
    $user = User::findOrFail($id);
    return response()->json($user);
}

public function update(Request $request, $id)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'gender' => 'required|string',
            'hobbies' => 'array',
            'country' => 'required|exists:countries,id',
            'state' => 'required|exists:states,id',
            'city' => 'required|exists:cities,id',
            'technologies' => 'array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::findOrFail($id);

        // Update user data
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->gender = $request->input('gender');
        $user->hobbies = $request->input('hobbies');
        $user->country = $request->input('country');
        $user->state = $request->input('state');
        $user->city = $request->input('city');
        $user->technologies = $request->input('technologies');

        // Handle image upload if present
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('images', 'public');
            $user->image = $imagePath;
        }

        $user->save();

        return response()->json(['success' => 'User updated successfully']);
    }

public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();
    return response()->json(['success' => 'User deleted successfully.']);
}

public function getCountries()
{
    $countries = Country::all();
    return response()->json($countries);
}

public function getStates($country_id)
{
    $states = State::where('country_id', $country_id)->get();
    return response()->json($states);
}

public function getCities($state_id)
{
    $cities = City::where('state_id', $state_id)->get();
    return response()->json($cities);
}


}
