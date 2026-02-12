<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Team;
use App\Models\TeamDetails;
use Illuminate\Http\Request;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\Upload;
use App\Http\Traits\Notify;

class TeamController extends Controller
{
    use Upload, Notify;

    public function teamList()
    {
        $data['team'] = Team::with('teamDetails')->latest()->get();
        return view('admin.team.list', $data);
    }

    public function teamCreate()
    {
        $data['languages'] = Language::all();
        return view('admin.team.create', $data);
    }

    public function teamStore(Request $request, $language = null)
    {

        $purifiedData = Purify::clean($request->except('image', '_token', '_method'));

        if ($request->has('image')) {
            $purifiedData['image'] = $request->image;
        }

        $rules = [
            'name.*' => 'required|max:40',
            'email.*' => 'required',
            'phone' => 'sometimes|required',
            'position.*' => 'required',
            'experience' => 'sometimes|required',
            'level' => 'sometimes|required',
            'facebook_link' => 'nullable|url|max:2000',
            'twitter_link' => 'nullable|url|max:2000',
            'linkedin_link' => 'nullable|url|max:2000',
            'skype_link' => 'nullable|url|max:2000',
            'short_description.*' => 'required|max:1000',
            'biography.*' => 'required',
            'working_process.*' => 'required',
            'skill_name.*' => 'required',
            'skill_percentage.*' => 'required',
            'image' => 'max:3048|mimes:jpg,jpeg,png',
        ];
        $message = [
            'name.*.required' => 'Name field is required',
            'name.*.max' => 'This field may not be greater than :max characters',
            'email.*.required' => 'Email field is required',
            'phone' => 'Phone field is required',
            'position.*.required' => 'Position field is required',
            'experience' => 'Experience field is required',
            'level.*.required' => 'Lavel field is required',
            'short_description.*.required' => 'Short Description field is required',
            'biography.*.required' => 'Biography field is required',
            'working_process.*.required' => 'The Working process field is required',
            'image.required' => 'Image is required',
            'facebook_link.url' => 'This Facebook Link field must be an url',
            'twitter_link.url' => 'This Linkedin Link field must be an url',
            'linkedin_link.url' => 'This Facebook Link field must be an url',
            'skype_link.url' => 'This Linkedin Link field must be an url',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $team = new Team();
        $team->experience = $request->experience;
        $team->level = $request->level;
        $team->phone = $request->phone;
        $team->facebook_link = $request->facebook_link;
        $team->twitter_link = $request->twitter_link;
        $team->linkedin_link = $request->linkedin_link;
        $team->skype_link = $request->skype_link;
        $input_form = [];
        if ($request->has('skill_name')) {
            for ($a = 0; $a < count($request->skill_name); $a++) {
                $arr = array();
                $arr['field_name'] = clean($request->skill_name[$a]);
                $arr['field_value'] = $request->skill_percentage[$a];

                $input_form[$arr['field_name']] = $arr;
            }
        }

        $team->top_skills = $input_form;

        if ($request->hasFile('image')) {
            try {
                $team->image = $this->uploadImage($request->image, config('location.team.path'), config('location.team.size'), $team->image);
            } catch (\Exception $exp) {
                return back()->with('error', __('Image could not be uploaded.'));
            }
        }

        $team->save();

        $team->teamDetails()->create([
            'language_id' => $language,
            'name' => $purifiedData["name"][$language],
            'email' => $purifiedData["email"][$language],
            'position' => $purifiedData["position"][$language],
            'short_description' => $purifiedData["short_description"][$language],
            'biography' => $purifiedData["biography"][$language],
            'my_working_process' => $purifiedData["working_process"][$language],

        ]);

        return redirect()->route('admin.team.list')->with('success', 'Team Member Add Successfully.');
    }

    public function teamEdit($id)
    {
        $data['languages'] = Language::all();
        $data['teamDetails'] = TeamDetails::with('team')->where('team_id', $id)->get()->groupBy('language_id');

        return view('admin.team.edit', $data, compact('id'));
    }

    public function teamUpdate(Request $request, $id, $language_id)
    {

        $purifiedData = Purify::clean($request->except('image', '_token', '_method'));

        if ($request->has('image')) {
            $purifiedData['image'] = $request->image;
        }

        $rules = [
            'name.*' => 'required|max:40',
            'email.*' => 'required',
            'phone' => 'sometimes|required',
            'position.*' => 'required',
            'experience' => 'sometimes|required',
            'level' => 'sometimes|required',
            'facebook_link' => 'nullable|url|max:2000',
            'twitter_link' => 'nullable|url|max:2000',
            'linkedin_link' => 'nullable|url|max:2000',
            'skype_link' => 'nullable|url|max:2000',
            'short_description.*' => 'required|max:1000',
            'biography.*' => 'required',
            'working_process.*' => 'required',
            'skill_name.*' => 'required',
            'skill_percentage.*' => 'required',
            'image' => 'max:3048|mimes:jpg,jpeg,png',
        ];
        $message = [
            'name.*.required' => 'Name field is required',
            'name.*.max' => 'This field may not be greater than :max characters',
            'email.*.required' => 'Email field is required',
            'phone' => 'Phone field is required',
            'position.*.required' => 'Position field is required',
            'experience' => 'Experience field is required',
            'level.*.required' => 'Lavel field is required',
            'short_description.*.required' => 'Short Description field is required',
            'biography.*.required' => 'Biography field is required',
            'working_process.*.required' => 'The Working process field is required',
            'image.required' => 'Image is required',
            'facebook_link.url' => 'This Facebook Link field must be an url',
            'twitter_link.url' => 'This Linkedin Link field must be an url',
            'linkedin_link.url' => 'This Facebook Link field must be an url',
            'skype_link.url' => 'This Linkedin Link field must be an url',

        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $team = Team::findOrFail($id);
        if ($request->has('experience')) {
            $team->experience = $request->experience;
        }

        if ($request->has('level')) {
            $team->level = $request->level;
        }

        if ($request->has('phone')) {
            $team->phone = $request->phone;
        }

        if ($request->has('facebook_link')) {
            $team->facebook_link = $request->facebook_link;
        }

        if ($request->has('twitter_link')) {
            $team->twitter_link = $request->twitter_link;
        }

        if ($request->has('linkedin_link')) {
            $team->linkedin_link = $request->linkedin_link;
        }

        if ($request->has('skype_link')) {
            $team->skype_link = $request->skype_link;
        }

        if ($request->has('skill_name')) {
            $input_form = [];
            if ($request->has('skill_name')) {
                for ($a = 0; $a < count($request->skill_name); $a++) {
                    $arr = array();
                    $arr['field_name'] = $request->skill_name[$a];
                    $arr['field_value'] = $request->skill_percentage[$a];
                    $input_form[$arr['field_name']] = $arr;
                }
            }

            $team->top_skills = $input_form;
        }


        if ($request->hasFile('image')) {
            try {
                $team->image = $this->uploadImage($request->image, config('location.team.path'), config('location.team.size'), $team->image);
            } catch (\Exception $exp) {
                return back()->with('error', __('Image could not be uploaded.'));
            }
        }


        $team->save();


        $team->teamDetails()->updateOrCreate(
            [
                'language_id' => $language_id
            ],
            [
                'name' => $purifiedData["name"][$language_id],
                'email' => $purifiedData["email"][$language_id],
                'position' => $purifiedData["position"][$language_id],
                'short_description' => $purifiedData["short_description"][$language_id],
                'biography' => $purifiedData["biography"][$language_id],
                'my_working_process' => $purifiedData["working_process"][$language_id],
            ]
        );

        return redirect()->back()->with('success', 'Team Member Updated Successfully.');
    }

    public function teamDelete($id)
    {
        $team = Team::findOrFail($id);
        $old_image = $team->image;
        $location = config('location.team.path');

        if (!empty($old_image)) {
            unlink($location . '/' . $old_image);
        }

        $TeamDetails = TeamDetails::where('team_id', $id);
        $TeamDetails->delete();

        $team->delete();
        return back()->with('success', __('Tema has been deleted'));
    }
}
