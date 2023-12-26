<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function index(User $user)
    {
        $user = User::where('id',auth()->user()->id)->first();
        $data = ['user' => $user];
        return view('users.index',$data);
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:4089',
        ]);
        if (!$request->hasFile('photo')) {
            $user->photo = 'images/default.jpg';
        }
        else if ($request->hasFile('photo')) {
            // Delete the old image from storage
            if ($user->photo) {
                Storage::disk('user')->delete($user->photo);
            }

            // Upload the new image
            $image = $request->file('photo');
            $imageName = time().'.'.$image->getClientOriginalExtension();

            // Log the image file name
            Storage::disk('user')->put($imageName, file_get_contents($image));

            // Set the new image URL in the Product instance
            $user->photo = $imageName;
        }


        // Update other user attributes
            $user->update($request->except('photo'));

        // Save the user model
            $user->save();


        return redirect()->route('users.index');

    }
}
