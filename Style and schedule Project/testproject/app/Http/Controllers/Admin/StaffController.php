<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\Upload;
use App\Http\Traits\Notify;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    use Upload, Notify;

    public function teamList()
    {
        $staff = Admin::all();
        return view('admin.staff.index', compact('staff'));
    }

    public function teamCreate()
    {
        return view('admin.staff.create');
    }

    public function teamStore(Request $request)
    {

        $purifiedData = Purify::clean($request->except('image', '_token', '_method'));

        if ($request->has('image')) {
            $purifiedData['image'] = $request->image;
        }

        $rules = [
            'name.*' => 'required|max:40',
            'username'=>'required',
            'email.*' => 'required',
            'phone' => 'sometimes|required',
            'image' => 'max:3048|mimes:jpg,jpeg,png',
            'password' => 'required',
            'address'=>'required',
            'role'=>'required',
        ];
        $message = [
            'name.*.required' => 'The name field is required',
            'name.*.max' => 'The name field may not be greater than :max characters',
            'username.required' => 'The username field is required',
            'email.*.required' => 'The email field is required',
            'phone.required' => 'The phone field is required',
            'image.max' => 'The image size should not exceed 3048 KB',
            'image.mimes' => 'The image must be in JPG, JPEG, or PNG format',
            'password.required' => 'The password field is required',
            'address.required' => 'The address field is required',
            'role.required' => 'The role field is required',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $team = new Admin();
        $team->name = $request->name;
        $team->username = $request->username;
        $team->email = $request->email;
        $team->phone = $request->phone;
        $team->address = $request->address;
        $team->role = $request->role;
        $team->admin_access=["admin.dashboard","admin.staff","admin.storeStaff","admin.updateStaff","admin.identify-form","admin.identify-form.store","admin.identify-form.store","admin.scheduleManage","admin.planList","admin.store.schedule","admin.update.schedule","admin.planCreate","admin.planEdit","admin.plans-active","admin.plans-inactive","admin.referral-commission","admin.referral-commission.store","admin.transaction","admin.transaction.search","admin.investments","admin.investments.search","admin.commissions","admin.commissions.search","admin.users","admin.users.search","admin.email-send","admin.user.transaction","admin.user.fundLog","admin.user.withdrawal","admin.user.commissionLog","admin.user.referralMember","admin.user.plan-purchaseLog","admin.user.userKycHistory","admin.kyc.users.pending","admin.kyc.users","admin.user-edit","admin.user-multiple-active","admin.user-multiple-inactive","admin.send-email","admin.user.userKycHistory","admin.user-balance-update","admin.payment.methods","admin.deposit.manual.index","admin.deposit.manual.create","admin.edit.payment.methods","admin.deposit.manual.edit","admin.payment.pending","admin.payment.log","admin.payment.search","admin.payment.action","admin.payout-method","admin.payout-log","admin.payout-request","admin.payout-log.search","admin.payout-method.create","admin.payout-method.edit","admin.payout-action","admin.ticket","admin.ticket.view","admin.ticket.reply","admin.ticket.delete","admin.subscriber.index","admin.subscriber.sendEmail","admin.subscriber.remove","admin.basic-controls","admin.email-controls","admin.email-template.show","admin.sms.config","admin.sms-template","admin.notify-config","admin.notify-template.show","admin.notify-template.edit","admin.basic-controls.update","admin.email-controls.update","admin.email-template.edit","admin.sms-template.edit","admin.notify-config.update","admin.notify-template.update","admin.language.index","admin.language.create","admin.language.edit","admin.language.keywordEdit","admin.language.delete","admin.manage.theme","admin.logo-seo","admin.breadcrumb","admin.template.show","admin.content.index","admin.content.create","admin.logoUpdate","admin.seoUpdate","admin.breadcrumbUpdate","admin.content.show","admin.content.delete"];
        $team->password = Hash::make($request->staffpassword);
        $team->status = 1;
        $input_form = [];

        if ($request->hasFile('image')) {
            try {
                $team->image = $this->uploadImage($request->image, config('location.admin.path'), config('location.admin.size'), $team->image);
            } catch (\Exception $exp) {
                return back()->with('error', __('Image could not be uploaded.'));
            }
        }

        $team->save();

        return redirect()->route('admin.staff.list')->with('success', 'Staff Member Add Successfully.');
    }

    public function teamEdit($id)
    {

        $data = Admin::find($id);
        return view('admin.staff.edit', compact('data'));
    }

    public function teamUpdate(Request $request, $id)
    {

        $purifiedData = Purify::clean($request->except('image', '_token', '_method'));

        if ($request->has('image')) {
            $purifiedData['image'] = $request->image;
        }

            $rules = [
                'name.*' => 'sometimes|required|max:40',
                'username' => 'sometimes|required',
                'email.*' => 'sometimes|required',
                'phone' => 'sometimes|required',
                'image' => 'sometimes|max:3048|mimes:jpg,jpeg,png',
                'password' => 'sometimes',
                'address' => 'sometimes|required',
                'role' => 'sometimes|required',
            ];


        $message = [
            'name.*.required' => 'The name field is required',
            'name.*.max' => 'The name field may not be greater than :max characters',
            'username.required' => 'The username field is required',
            'email.*.required' => 'The email field is required',
            'phone.required' => 'The phone field is required',
            'image.max' => 'The image size should not exceed 3048 KB',
            'image.mimes' => 'The image must be in JPG, JPEG, or PNG format',
            'password.required' => 'The password field is required',
            'address.required' => 'The address field is required',
            'role.required' => 'The role field is required',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $team = Admin::findOrFail($id);
        if ($request->has('name')) {
            $team->name = $request->name;
        }

        if ($request->has('email')) {
            $team->email = $request->email;
        }

        if ($request->has('phone')) {
            $team->phone = $request->phone;
        }

        if ($request->has('address')) {
            $team->address = $request->address;
        }

        if ($request->has('password')) {
            $team->password = Hash::make($request->password);
        }

        if ($request->has('role')) {
            $team->role = $request->role;
        }

        if ($request->hasFile('image')) {
            try {
                $team->image = $this->uploadImage($request->image, config('location.admin.path'), config('location.admin.size'), $team->image);
            } catch (\Exception $exp) {
                return back()->with('error', __('Image could not be uploaded.'));
            }
        }

        $team->save();

        return redirect()->back()->with('success', 'Team Member Updated Successfully.');
    }

    public function teamDelete($id)
    {
        $team = Admin::findOrFail($id);
        $old_image = $team->image;
        $location = config('location.admin.path');

        if (!empty($old_image)) {
            unlink($location . '/' . $old_image);
        }

        $team->delete();
        return back()->with('success', __('Staff has been deleted'));
    }
}
